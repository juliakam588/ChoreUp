<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../repository/HouseholdRepository.php';
require_once __DIR__ . '/../repository/UserRoleRepository.php';
require_once __DIR__ . '/../repository/RoleRepository.php';

class SecurityController extends AppController
{

    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/jpg'];
    const UPLOAD_DIRECTORY = '../../public/uploads/';

    private $userRepository;
    private $householdRepository;
    private $userRoleRepository;
    private $roleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->householdRepository = new HouseholdRepository();
        $this->userRoleRepository = new UserRoleRepository();
        $this->roleRepository=new RoleRepository();
    }


    public function login()
    {
        if (!$this->isPost()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $user = $this->userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $userHouseholdId = $this->householdRepository->getUserHouseholdId($user->getId());

        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName()
        ];

        if ($userHouseholdId !== null) {
            $_SESSION['user']['household_id'] = $userHouseholdId;
            (new DashboardController())->dashboard();
            exit();
        }

        header("Location: http://{$_SERVER['HTTP_HOST']}/afterRegistration");
        exit();
    }


    public function logout()
    {
        session_unset();
        session_destroy();

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
        exit();
    }

    public function registration()
    {
        if (!$this->isPost()) {
            return $this->render('registration');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        if (is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

        }
        if ($this->userRepository->getUser($email)) {
            return $this->render('registration', ['messages' => ['Account with this email already exists!']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $user = new User(null, $email, $hashedPassword, $name, $_FILES['file']['name'], null);

        $userId = $this->userRepository->addUser($user);

        $user->setId($userId);

        return $this->render('login', ['messages' => ['You\'ve been succesfully registrated!']]);
    }


    public function afterRegistration()
    {
        if (!$this->isPost()) {
            return $this->render('afterRegistration');
        }

        $userEmail = $_SESSION['user']['email'];
        $user = $this->userRepository->getUser($userEmail);

        if (isset($_POST['create'])) {
            $this->handleCreateHousehold($user);
        } elseif (isset($_POST['code']) && !empty(trim($_POST['code']))) {
            $this->handleJoinHousehold($user, $_POST['code']);
        }
    }

    private function handleCreateHousehold(User $user)
    {
        $code = $this->householdRepository->generateHouseholdCode();
        $household = $this->householdRepository->createHouseholdWithDefaultChores($code);

        $role = $this->roleRepository->getRoleByName('Household Admin');
        $this->handleUserHouseholdAssociation($user, $household, $role);
    }

    private function handleJoinHousehold(User $user, string $code)
    {
        $household = $this->householdRepository->getHouseholdByCode($code);
        $role = $this->roleRepository->getRoleByName('Member');
        if ($household) {
            $this->handleUserHouseholdAssociation($user, $household, $role);
        } else {
            return $this->render('afterRegistration', ['messages' => ['Invalid code provided.']]);
        }
    }

    private function handleUserHouseholdAssociation(User $user, Household $household, Role $role)
    {
        $householdId = $household->getHouseholdId();
        $this->householdRepository->addUserToHousehold($user, $household);
        $this->userRoleRepository->assignRoleToUser($user, $household, $role);
        $_SESSION['user']['household_id'] = $householdId;

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/dashboard");
        exit();
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }


}