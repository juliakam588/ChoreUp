<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);


Routing::get('', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::get('afterRegistration', 'DefaultController');
Routing::get('dashboard', 'DefaultController');
Routing::get('FileNotFound', 'ErrorController');
Routing::get('household', 'DefaultController');
Routing::get('chores', 'DefaultController');
Routing::get('chore_mopping', 'DefaultController');
Routing::get('chore_vacuum', 'DefaultController');
Routing::get('chore_rubbish', 'DefaultController');
Routing::get('chores', 'DefaultController');
Routing::get('edit', 'DefaultController');
Routing::post('login', 'SecurityController');
Routing::post('registration', 'SecurityController');

Routing::run($path);