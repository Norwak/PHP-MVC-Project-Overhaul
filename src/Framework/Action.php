<?php
declare(strict_types=1);
namespace Framework;
use ReflectionMethod;


class Action {

  function __construct(
    private object $controller,
    private string $action,
    private array $extra_params,
  ) {}


  private function getActionName(): string {
    return lcfirst(str_replace('-', '', ucwords(strtolower($this->action), '-')));
  }


  function getArguments(): array {
    $action = $this->getActionName();
    
    $args = [];
    $method = new ReflectionMethod($this->controller, $action);
    foreach ($method->getParameters() as $parameter) {
      $name = $parameter->getName();
      $args[$name] = $this->extra_params[$name];
    }

    return $args;
  }

}