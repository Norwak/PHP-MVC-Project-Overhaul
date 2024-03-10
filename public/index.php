<?php
declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function(string $class_name) {
  $class_name = str_replace('\\', '/', $class_name);
  $class_name_arr = explode('/', $class_name);

  $types = ['Controller', 'Model', 'View'];
  foreach ($types as $type) {
    if (end($class_name_arr) !== $type && str_ends_with(end($class_name_arr), $type)) {
      $class_name = preg_replace("/$type$/", '', $class_name) . '.' . strtolower($type) . '.php';
    }
  }

  if (!str_ends_with($class_name, '.php')) {
    $class_name .= '.php';
  }

  require ROOT_PATH . "/src/$class_name";
});

$dotenv = new Framework\Dotenv();
$dotenv->load(ROOT_PATH . '/.env');

set_error_handler('Framework\ErrorHandler::handleError');
set_exception_handler('Framework\ErrorHandler::handleException');



$router = require ROOT_PATH . '/config/routes.php';
$container = require ROOT_PATH . '/config/services.php';
$middleware = require ROOT_PATH . '/config/middleware.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];
$request = new Framework\Request($uri, $method, $_GET, $_POST, $_FILES, $_COOKIE, $_SERVER);

$dispatcher = new Framework\Dispatcher($router, $container, $middleware);
$response = $dispatcher->handle($request);
$response->send();