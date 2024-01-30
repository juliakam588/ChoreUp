<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);


Routing::get('', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::get('afterRegistration', 'DefaultController');
Routing::get('dashboard', 'DashboardController');
Routing::get('FileNotFound', 'ErrorController');
Routing::get('logout', 'SecurityController');
Routing::get('edit', 'DashboardController');
Routing::post('editSchedule', 'EditController');
Routing::get('household', 'HouseholdController');
Routing::get('generate', 'ScheduleController');
Routing::post('login', 'SecurityController');
Routing::post('registration', 'SecurityController');
Routing::post('afterRegistration', 'SecurityController');
Routing::post('dashboard', 'DashboardController');
Routing::post('generate', 'ScheduleController');
Routing::get('editChore', 'EditController');
Routing::post('saveChore', 'EditController');
Routing::post('finishEditing', 'EditController');
Routing::post('updateChoreStatus', 'DashboardController');
Routing::get('confirmDelete', 'EditController');
Routing::post('deleteChore', 'EditController');
Routing::get('chooseUserToDelete', 'HouseholdController');
Routing::post('deleteUser', 'HouseholdController');
Routing::get('editChoreSettings', 'HouseholdController');
Routing::post('saveChoreSettings', 'HouseholdController');
Routing::run($path);