<?php
declare(strict_types=1);
namespace Framework;
use Framework\Request;
use Framework\Interfaces\RequestWrapInterface;
use Framework\Base\Controller;

class ControllerRequestWrap implements RequestWrapInterface {

  function __construct(
    private Controller $controller,
    private string $action,
    private array $args,
  ) {}

  function handle(Request $request): array {
    return ($this->controller)->{$this->action}(...$this->args);
  }

}