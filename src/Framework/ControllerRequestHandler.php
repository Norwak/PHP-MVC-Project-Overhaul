<?php
declare(strict_types=1);
namespace Framework;

class ControllerRequestHandler implements RequestHandlerInterface {

  function __construct(
    private Controller $controller,
    private string $action,
    private array $args,
  ) {}

  function handle(Request $request): Response {
    $this->controller->setRequest($request);
    
    return ($this->controller)->{$this->action}(...$this->args);
  }

}