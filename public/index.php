<?php
declare(strict_types=1);
define('ROOT_PATH', dirname(__DIR__, 1));



spl_autoload_register(function(string $class_name) {
  $class_name = str_replace('\\', '/', $class_name);
  $class_name_arr = explode('/', $class_name);
  $class_name_last = end($class_name_arr);

  $types = ['Controller', 'Model', 'View'];
  foreach ($types as $type) {
    if ($class_name_last !== $type && str_ends_with($class_name_last, $type)) {
      $class_name = preg_replace("/$type$/", '', $class_name) . '.' . strtolower($type) . '.php';
    }
  }

  if (!str_ends_with($class_name, '.php')) {
    $class_name .= '.php';
  }

  require ROOT_PATH . "/src/$class_name";
});



$dotenv = new Framework\Dotenv(ROOT_PATH . '/.env');
$dotenv->load();



$exception_output_pipe = new Framework\ExceptionOutputPipe();
set_error_handler([$exception_output_pipe, 'convertErrorToException']);
set_exception_handler([$exception_output_pipe, 'showException']);



$routes = require ROOT_PATH . '/config/routes.php';
$dependency_registry = require ROOT_PATH . '/config/services.php';
$middleware = require ROOT_PATH . '/config/middleware.php';

$request = $dependency_registry->getOrResolve(Framework\Request::class);

$dispatcher = new Framework\Dispatcher($routes, $dependency_registry, $middleware);
$response_args = $dispatcher->handle($request);

$response = new Framework\Response(...$response_args);
$response->send();