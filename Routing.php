<?php
require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/ErrorController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/HouseholdController.php';
require_once 'src/controllers/EditController.php';
require_once 'src/controllers/ScheduleController.php';



class Routing {

  public static $routes;

  public static function get($url, $controller) {
    self::$routes[$url] = $controller;
  }

  public static function post($url, $controller) {
    self::$routes[$url] = $controller;
  }

  public static function run ($url) {
    $action = explode("/", $url)[0];
    if (!array_key_exists($action, self::$routes)) {
      $error = new ErrorController();
      return $error->FileNotFound();
    }

    $controller = self::$routes[$action];
    $object = new $controller;
    $action = $action ?: 'index';

      $id = $urlParts[1] ?? '';

      $object->$action($id);
  }
}