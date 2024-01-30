<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ScheduleRepository.php';
require_once __DIR__ . '/../repository/UserChoresRepository.php';
require_once __DIR__ . '/../repository/ChoreRepository.php';
require_once __DIR__ . '/../repository/HouseholdRepository.php';

class ScheduleController extends AppController
{

    private $scheduleRepository;
    private $userChoresRepository;
    private $householdRepository;
    private $choreRepository;

    public function __construct()
    {
        parent::__construct();
        $this->scheduleRepository = new ScheduleRepository();
        $this->userChoresRepository = new UserChoresRepository();
        $this->householdRepository = new HouseholdRepository();
        $this->choreRepository = new ChoreRepository();

    }


    public function generate()
    {
        if ($this->isPost()) {
            $this->generateSchedule();
        } else {
            $this->generateView();
        }
    }


    public function generateView()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }

        $chores = $this->choreRepository->getAllChores();
        $this->render('generate', ['chores' => $chores]);
    }

    public function generateSchedule()
    {
        if (!$this->isPost() || !isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        $selectedChores = $_POST['chores'] ?? [];
        $householdId = $_SESSION['user']['household_id'];
        $choreSettings = $this->householdRepository->getChoreSettingsForHousehold($householdId);
        $householdMembers = $this->householdRepository->getHouseholdMembers($householdId);

        $currentDate = new DateTime();
        $endDate = (clone $currentDate)->modify('+6 days');

        $schedule = $this->initializeScheduleStructure($currentDate);
        $timeTracking = $this->initializeTimeTracking($householdMembers);

        $choreCount = [];

        foreach ($selectedChores as $choreId) {

            if (!isset($choreSettings[$choreId])) continue;
            if (!isset($choreCount[$choreId])) {
                $choreCount[$choreId] = 0;
            }
            $timesAssignedThisCycle = 0;
            for ($i = 0; $i < $choreSettings[$choreId]['times_in_a_week']; $i++) {
                $possibleDays = $this->getRandomDayForChore($schedule, $choreId, $choreSettings[$choreId]['times_in_a_week']);
                foreach ($possibleDays as $dayName) {
                    $user = $this->getRandomUser($householdMembers);

                    if ($this->canAssignChore($user, $dayName, $choreId, $choreSettings, $timeTracking)) {
                        $dateScheduled = $this->getDateForDayName($dayName, $currentDate);

                        $timesAssignedThisCycle++;
                        $choreCount[$choreId]++;

                        $timeTracking[$user['id']][$dayName] += $choreSettings[$choreId]['duration'];

                        $schedule[$dayName]['tasks'][] = [
                            'user_id' => $user['id'],
                            'chore_id' => $choreId,
                            'date_scheduled' => $dateScheduled
                        ];
                        if ($timesAssignedThisCycle >= $choreSettings[$choreId]['times_in_a_week']) {
                            break;
                        }
                    }
                }
                if ($timesAssignedThisCycle >= $choreSettings[$choreId]['times_in_a_week']) {
                    break;
                }
            }        }

        $scheduleId = $this->scheduleRepository->createSchedule($householdId, $currentDate->format('Y-m-d'), $endDate->format('Y-m-d'));
        $this->userChoresRepository->saveScheduleToDatabase($schedule, $scheduleId);

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
        exit();
    }

    private function initializeScheduleStructure($currentDate)
    {
        $schedule = [];
        for ($i = 0; $i < 7; $i++) {
            $date = clone $currentDate;
            $date->modify("+$i days");
            $schedule[$date->format('Y-m-d')] = [
                'tasks' => []
            ];
        }
        return $schedule;
    }

    private function getRandomDayForChore($schedule, $choreId, $timesInAWeek)
    {
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $possibleDays = [];

        foreach ($schedule as $day => $tasks) {
            foreach ($tasks as $task) {
                if (isset($task['chore_id']) && $task['chore_id'] === $choreId) {
                    $dayOfWeek = (new DateTime($day))->format('l');
                    if (($key = array_search($dayOfWeek, $daysOfWeek)) !== false) {
                        unset($daysOfWeek[$key]);
                    }
                }
            }
        }

        while (count($possibleDays) < $timesInAWeek && count($daysOfWeek) > 0) {
            $randomIndex = array_rand($daysOfWeek);
            $day = $daysOfWeek[$randomIndex];
            if (!in_array($day, $possibleDays)) {
                $possibleDays[] = $day;
            }
            unset($daysOfWeek[$randomIndex]);
        }

        return $possibleDays;
    }

    private function getRandomUser($householdMembers)
    {
        $randomIndex = array_rand($householdMembers);
        return $householdMembers[$randomIndex];
    }

    private function getDateForDayName($dayName, $currentDate)
    {
        $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $currentDayOfWeek = array_search($currentDate->format('l'), $daysOfWeek);
        $desiredDayOfWeek = array_search($dayName, $daysOfWeek);
        $daysDifference = $desiredDayOfWeek - $currentDayOfWeek;
        $date = clone $currentDate;
        $date->modify("$daysDifference days");
        return $date->format('Y-m-d');
    }

    private function initializeTimeTracking($householdMembers)
    {
        $timeTracking = [];
        foreach ($householdMembers as $member) {
            $timeTracking[$member['id']] = [
                'Monday' => 0,
                'Tuesday' => 0,
                'Wednesday' => 0,
                'Thursday' => 0,
                'Friday' => 0,
                'Saturday' => 0,
                'Sunday' => 0,
            ];
        }
        return $timeTracking;
    }

    private function canAssignChore($user, $dayName, $choreId, $choreSettings, &$timeTracking)
    {
        $maxDailyChoreTime = 8 * 60;

        $userId = $user['id'];
        $choreDuration = $choreSettings[$choreId]['duration'];

        if (!isset($timeTracking[$userId][$dayName])) {
            $timeTracking[$userId][$dayName] = 0;
        }

        if (($timeTracking[$userId][$dayName] + $choreDuration) > $maxDailyChoreTime) {
            return false;
        }

        return true;
    }



}