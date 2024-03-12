<?php
declare(strict_types=1);
namespace Framework;
use UnexpectedValueException;

class MiddlewareChain {

  function __construct(
    private string $chain,
    private array $middleware_classes,
    private DependencyRegistry $dependency_registry,
  ) {}


  function form(): array {
    if (!$this->chain) return [];

    $middleware = explode('|', $this->chain);

    array_walk($middleware, function (&$value) {
      if (!array_key_exists($value, $this->middleware_classes)) {
        throw new UnexpectedValueException("Middleware '$value' not found in config settings");
      }

      $value = $this->dependency_registry->getOrResolve($this->middleware_classes[$value]);
    });

    return $middleware;
  }

}