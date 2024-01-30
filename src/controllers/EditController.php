<?php
require_once 'AppController.php';
require_once __DIR__.'/../repository/ScheduleRepository.php';
require_once __DIR__.'/../repository/UserChoresRepository.php';
require_once __DIR__.'/../repository/HouseholdRepository.php';

class EditController extends AppController
{

    private $scheduleRepository;
    private $userChoresRepository;
    private $householdRepository;
    public function __construct()
    {
        parent::__construct();
        $this->scheduleRepository = new ScheduleRepository();
        $this->userChoresRepository = new UserChoresRepository();
        $this->householdRepository = new HouseholdRepository();
    }


    public function editSchedule($householdId) {
        if (!isset($_SESSION['user']) || $_SESSION['user']['household_id'] != $householdId) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }
        $tasks = $this->scheduleRepository->getScheduleTasks($householdId);

        $this->render('edit', ['tasks' => $tasks, 'householdId' => $householdId]);
    }

    public function editChore() {
        $userChoreId = $_GET['userChoreId'] ?? null;
        $householdId = $_SESSION['user']['household_id'] ?? null;

        if (!$userChoreId || !$householdId) {
            $this->render('error', ['message' => 'Missing chore or household ID.']);
            return;
        }

        $choreDetails = $this->userChoresRepository->getUserChoreDetails($userChoreId);
        $members = $this->householdRepository->getHouseholdMembers($householdId);
        $weekdays = $this->generateWeekdaysList();

        $this->render('editChore', [
            'choreDetails' => $choreDetails,
            'members' => $members,
            'weekdays' => $weekdays
        ]);
    }

    private function generateWeekdaysList() {
        $weekdays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        $today = date('N') - 1;
        $sortedWeekdays = array_merge(array_slice($weekdays, $today), array_slice($weekdays, 0, $today));
        return $sortedWeekdays;
    }

    public function saveChore() {


        $userChoreId = $_POST['userChoreId'] ?? null; // zmiana tutaj
        $userId = $_POST['members'] ?? null;
        $dayName = $_POST['days'] ?? null;

        if (!$userId || !$dayName) {
            $_SESSION['messages'] = ['Please select both a user and a day.'];
            header('Location: /editChore?userChoreId=' . $userChoreId . '&householdId=' . $_SESSION['user']['household_id']);
            exit();
        }

        $this->userChoresRepository->updateUserChore($userChoreId, $userId, $dayName);

        header('Location: /edit');
        exit();

    }
    public function confirmDelete() {
        $userChoreId = $_GET['userChoreId'] ?? null;
        if (!$userChoreId) {
            $this->render('error', ['message' => 'Missing chore ID.']);
            return;
        }
        $this->render('confirmDelete', ['userChoreId' => $userChoreId]);
    }

    public function deleteChore() {
        $userChoreId = $_POST['userChoreId'] ?? null;
        if (!$userChoreId) {
            $this->render('error', ['message' => 'An error occurred.']);
            return;
        }
        $this->userChoresRepository->deleteUserChore($userChoreId);
        header('Location: /edit');
        exit();
    }
    public function finishEditing() {
        header('Location: /dashboard');
        exit();
    }
}
