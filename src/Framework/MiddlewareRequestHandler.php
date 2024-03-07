<?php
declare(strict_types=1);
namespace Framework;

class MiddlewareRequestHandler implements RequestHandlerInterface {

  function __construct(
    private array $middlewares,
    private ControllerRequestHandler $controller_handler,
  ) {}


  function handle(Request $request): Response {
    $middleware = array_shift($this->middlewares);
    if ($middleware === null) {
      return $this->controller_handler->handle($request);
    }

    return $middleware->process($request, $this);
  }

}