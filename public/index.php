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



$core = new Framework\Core();
$core->start();