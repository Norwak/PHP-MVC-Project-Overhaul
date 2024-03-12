<?php
declare(strict_types=1);
namespace Framework;

class RouteParams {

  function __construct(
    private string $controllerName,
    private string $action,
    private string $middleware_chain = '',
    private string $method = '',
    private string $namespace = '',
    private array $extra = [],
  ) {}


  function controllerName(): string {
    return $this->controllerName;
  }


  function action(): string {
    return $this->action;
  }


  function middleware_chain(): string {
    return $this->middleware_chain ?? '';
  }


  function method(): string {
    $method = strtoupper($this->method);

    if (!in_array($method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'], true)) {
      throw new BadRequestException("Unsupported method: '$method'");
    }

    return $method ?? 'GET';
  }


  function namespace(): string {
    return $this->namespace ?? '';
  }


  function extra(): array {
    return $this->extra ?? [];
  }

}