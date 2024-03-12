<?php
declare(strict_types=1);
namespace Framework;
use Framework\Exceptions\NotFoundException;

class ControllerFactory {

  function __construct(
    private DependencyRegistry $dependency_registry,
  ) {}

  private function getControllerName(string $controllerName, string $param_namespace): string {
    // turn "controller-name" into "ControllerName"
    $controllerName = str_replace('-', '', ucwords(strtolower($controllerName), '-'));

    $namespace = 'App\Modules\\' . $controllerName;
    if ($param_namespace) {
      $controllerName = $namespace . '\\' . $param_namespace . 'Controller';
    } else {
      $controllerName = $namespace . '\\' . $controllerName . 'Controller';
    }

    return $controllerName;
  }


  function create(string $controller_name, string $namespace): object {
    $controllerName = $this->getControllerName($controller_name, $namespace);
    return $this->dependency_registry->getOrResolve($controllerName);
  }

}