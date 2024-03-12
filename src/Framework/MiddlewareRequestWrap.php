<?php
declare(strict_types=1);
namespace Framework;
use Framework\Interfaces\RequestWrapInterface;

class MiddlewareRequestWrap implements RequestWrapInterface {

  function __construct(
    private array $middleware,
    private ControllerRequestWrap $controller_handler,
  ) {}


  function handle(Request $request): array {
    $middleware = array_shift($this->middleware);
    if ($middleware === null) {
      return $this->controller_handler->handle($request);
    }

    return $middleware->process($request, $this);
  }

}