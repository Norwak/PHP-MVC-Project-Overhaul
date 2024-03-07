<?php
declare(strict_types=1);
namespace Framework;
use ReflectionClass;
use Closure;
use ReflectionNamedType;
use InvalidArgument;

class Container {

  private array $registry = [];


  function get(string $class_name): object {
    if (array_key_exists($class_name, $this->registry)) {
      return $this->registry[$class_name]();
    }

    $reflector = new ReflectionClass($class_name);
    $constructor = $reflector->getConstructor();
    if ($constructor === null) {
      return new $class_name();
    }
    
    $dependencies = [];
    foreach ($constructor->getParameters() as $parameter) {
      $type = $parameter->getType();

      if ($type === null) {
        throw new InvalidArgumentException("Constructor parameter '{$parameter->getName()}' in the '$class_name' class has no type declaration");
      }

      if (!($type instanceof ReflectionNamedType)) {
        throw new Exception("Constructor parameter '{$parameter->getName()}' in the '$class_name' class is an invalid type: '$type' - only single named types supported");
      }

      if ($type->isBuiltIn()) {
        throw new Exception("Unable to resolve constructor parameter '{$parameter->getName()}' of type '$type' in the '$class_name' class");
      }

      $dependencies[] = $this->get((string) $type);
    }

    return new $class_name(...$dependencies);
  }


  function set(string $name, Closure $value): void {
    $this->registry[$name] = $value;
  }

}