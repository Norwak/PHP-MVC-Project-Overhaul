<?php
declare(strict_types=1);
namespace Framework;
use Framework\Request;
use Framework\Interfaces\RequestHandlerInterface;
use Framework\Base\Controller;

class ControllerRequestHandler implements RequestHandlerInterface {

  function __construct(
    private Controller $controller,
    private string $action,
    private array $args,
  ) {}

  function handle(Request $request): array {
    return ($this->controller)->{$this->action}(...$this->args);
  }

}