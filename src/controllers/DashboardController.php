<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/ScheduleRepository.php';
require_once __DIR__ . '/../repository/UserChoresRepository.php';


class DashboardController extends AppController
{

    private $scheduleRepository;
    private $userChoresRepository;


    public function __construct()
    {
        parent::__construct();
        $this->scheduleRepository = new ScheduleRepository();
        $this->userChoresRepository = new UserChoresRepository();
    }

    public function dashboard()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            exit();
        }
        $userName = $_SESSION['user']['name'];
        $householdId = $_SESSION['user']['household_id'];
        $lastSchedule = $this->scheduleRepository->getLastScheduleForHousehold($householdId);


        $lastScheduleWeek = $lastSchedule ? (new DateTime($lastSchedule['end_date']))->format("W") : null;
        $currentWeek = (new DateTime())->format("W");

        $scheduleExists = $lastScheduleWeek !== null && $lastScheduleWeek >= $currentWeek;
        $tasks = $this->scheduleRepository->getScheduleTasks($householdId);
        $groupedTasks = [];
        $hasTasks = false;

        foreach ($tasks as $taskObject) {
            $dayName = $taskObject->getDayName();
            if (!isset($groupedTasks[$dayName])) {
                $groupedTasks[$dayName] = [];
            }
            $groupedTasks[$dayName][] = $taskObject;
            $hasTasks = true;
        }

        $scheduleExists = $scheduleExists && $hasTasks;

        $totalTasksCount = $this->scheduleRepository->getTasksCount($householdId);
        $completedTasksCount = $this->userChoresRepository->getCompletedTasksCount($householdId);

        $this->render('dashboard', [
            'scheduleExists' => $scheduleExists,
            'groupedTasks' => $groupedTasks,
            'userName' => $userName,
            'totalTasksCount' => $totalTasksCount,
            'completedTasksCount' => $completedTasksCount
        ]);
    }


    public function updateChoreStatus() {
        if (!$this->isPost() || !isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'You must be logged in to update the status.']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $choreId = $data['choreId'] ?? null;
        $isCompleted = $data['isCompleted'] ?? null;

        if ($choreId === null || $isCompleted === null) {
            echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
            exit();
        }

        $statusId = $isCompleted ? 2 : 1;
        $result = $this->userChoresRepository->updateChoreStatus($choreId, $statusId);


        $householdId = $_SESSION['user']['household_id'];
        $totalTasks = $this->scheduleRepository->getTasksCount($householdId);
        $completedTasks = $this->userChoresRepository->getCompletedTasksCount($householdId);

        echo json_encode([
            'success' => $result,
            'totalTasks' => $totalTasks['totalTasks'],
            'completedTasks' => $completedTasks
        ]);
        exit();
    }

    public function edit()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        if (!isset($_SESSION['user']['household_id'])) {
            $this->render('dashboard', ['messages' => ['No household assigned.']]);
            return;
        }

        $householdId = $_SESSION['user']['household_id'];

        $editController = new EditController();
        $editController->editSchedule($householdId);
    }


}