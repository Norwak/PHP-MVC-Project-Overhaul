<?php
declare(strict_types=1);
namespace Framework;
use Framework\Interfaces\RequestHandlerInterface;

class MiddlewareRequestHandler implements RequestHandlerInterface {

  function __construct(
    private array $middlewares,
    private ControllerRequestHandler $controller_handler,
  ) {}


  function handle(Request $request): array {
    $middleware = array_shift($this->middlewares);
    if ($middleware === null) {
      return $this->controller_handler->handle($request);
    }

    return $middleware->process($request, $this);
  }

}