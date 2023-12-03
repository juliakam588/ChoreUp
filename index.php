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
Routing::post('login', 'SecurityController');

Routing::run($path);