<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/Household.php';
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../repository/HouseholdRepository.php';
require_once __DIR__ . '/../repository/ScheduleRepository.php';


class HouseholdController extends AppController
{
    private $householdRepository;
    private $scheduleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->householdRepository = new HouseholdRepository();
        $this->scheduleRepository = new ScheduleRepository();
    }

    public function household()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['household_id'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }
        $isAdmin = false;
        $householdId = $_SESSION['user']['household_id'];
        $household = $this->householdRepository->getHousehold($householdId);
        foreach ($household->getUsers() as $user) {
            if ($user->getId() === $_SESSION['user']['id'] && $user->getRole()->getName() === 'Household Admin') {
                $isAdmin = true;
                break;
            }
        }
        $members = $this->householdRepository->getHouseholdMembers($householdId);

        if ($isAdmin) {
            $householdCode = $this->householdRepository->getHouseholdCodeByHouseholdId($householdId);
        }
        $this->render('household', ['members' => $members,
            'household' => $household,
            'isAdmin' => $isAdmin
        ]);
    }

    public function deleteUser()
    {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        $userIdToDelete = $_POST['members'] ?? null;
        if ($userIdToDelete === null) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/household");
            exit();
        }

        if ($userIdToDelete == $_SESSION['user']['id']) {
            header("Location: http://{$_SERVER['HTTP_HOST']}/household");
            exit();
        }

        $householdId = $_SESSION['user']['household_id'];
        $household = $this->householdRepository->getHousehold($householdId);

        $this->householdRepository->deleteUserFromHousehold($userIdToDelete, $householdId);
        $admin = $this->findAdmin($household);

        $tasks = $this->scheduleRepository->getScheduleTasks($householdId);

        foreach ($tasks as $task) {
            if ($task->getUser()->getId() == $userIdToDelete) {
                $this->scheduleRepository->updateTaskUserId($task->getId(), $admin->getId());
            }
        }
        header("Location: http://{$_SERVER['HTTP_HOST']}/household");
        exit();
    }

    public function chooseUserToDelete()
    {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['household_id'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        $householdId = $_SESSION['user']['household_id'];
        $isAdmin = $this->checkIfUserIsAdmin($householdId);

        if (!$isAdmin) {
            $this->render('error', ['message' => 'You do not have permission to view this page.']);
            return;
        }

        $members = $this->householdRepository->getHouseholdMembers($householdId);
        $this->render('chooseUserToDelete', ['members' => $members]);

    }

    public function editChoreSettings() {
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['household_id'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        $householdId = $_SESSION['user']['household_id'];
        $isAdmin = $this->checkIfUserIsAdmin($householdId);

        if (!$isAdmin) {
            $this->render('error', ['message' => 'You do not have permission to view this page.']);
            return;
        }

        $choreSettings=$this->householdRepository->getChoreSettingsForHousehold($householdId);
        $this->render('editChoreSettings', ['choreSettings' => $choreSettings]);

    }

    public function saveChoreSettings() {
        if (!isset($_SESSION['user'])) {
            $this->render('login', ['messages' => ['Please log in to continue']]);
            return;
        }

        $householdId = $_SESSION['user']['household_id'] ?? null;
        if (!$householdId) {
            $this->render('error', ['message' => 'Household not found.']);
            return;
        }

        if ($this->isPost()) {
            $settings = $_POST['settings'] ?? [];
            foreach ($settings as $choreId => $choreSettings) {
                $timesInAWeek = $choreSettings['times_in_a_week'] ?? 1;
                $duration = $choreSettings['duration'] ?? 15;
                $timesInAWeek = max(1, min(7, $timesInAWeek));
                $duration = max(1, min(120, $duration));

                $this->householdRepository->updateChoreSettings($choreId, $timesInAWeek, $duration, $householdId);
            }

            header("Location: http://{$_SERVER['HTTP_HOST']}/household");
            exit();
        } else {
            $this->render('error', ['message' => 'Invalid request.']);
        }
    }


    private function checkIfUserIsAdmin($householdId): bool
    {
        $household = $this->householdRepository->getHousehold($householdId);
        foreach ($household->getUsers() as $user) {
            if ($user->getId() === $_SESSION['user']['id'] && $user->getRole()->getName() === 'Household Admin') {
                return true;
            }
        }
        return false;
    }

    private function findAdmin($household): ?User
    {
        $users = $household->getUsers();
        foreach ($users as $user) {
            if ($user->getRole()->getName() === "Household Admin") {
                return $user;
            }
        }
        return null;
    }


}