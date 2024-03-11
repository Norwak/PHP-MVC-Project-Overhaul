<?php
declare(strict_types=1);
namespace Framework;
use ReflectionMethod;
use Framework\Exceptions\NotFoundException;
use Framework\Interfaces\TemplateInterface;
use UnexpectedValueException;

class Dispatcher {

  function __construct(
    private array $routes,
    private Container $container,
    private array $middleware_classes
  ) {}


  private function getParamsFromRoute(array $routes, Request $request): array {
    $path = $request->path();
    $method = $request->method();
    $params = [];

    foreach ($routes as $route) {
      $params = $route->match($path, $method);
      if ($params) break;
    }
    if (!$params) {
      http_response_code(404);
      throw new NotFoundException("No route matched for '$path' with method '{$method}'");
    }

    return $params;
  }


  private function getControllerName(array $params): string {
    $controllerName = $params['controller'];
    
    // turn "controller-name" into "ControllerName"
    $controllerName = str_replace('-', '', ucwords(strtolower($controllerName), '-'));

    $namespace = 'App\Modules\\' . $controllerName;
    if (array_key_exists('namespace', $params)) {
      $controllerName = $namespace . '\\' . $params['namespace'] . 'Controller';
    } else {
      $controllerName = $namespace . '\\' . $controllerName . 'Controller';
    }

    return $controllerName;
  }


  private function getActionName(array $params): string {
    $actionName = $params['action'];
    $actionName = lcfirst(str_replace('-', '', ucwords(strtolower($actionName), '-')));

    return $actionName;
  }


  private function getActionArguments(string $controller, string $action, array $params): array {
    $args = [];

    $method = new ReflectionMethod($controller, $action);
    foreach ($method->getParameters() as $parameter) {
      $name = $parameter->getName();
      $args[$name] = $params[$name];
    }

    return $args;
  }


  private function getMiddleware(array $params): array {
    if (!array_key_exists("middleware", $params)) {
      return [];
    }

    $middleware = explode('|', $params['middleware']);

    array_walk($middleware, function (&$value) {
      if (!array_key_exists($value, $this->middleware_classes)) {
        throw new UnexpectedValueException("Middleware '$value' not found in config settings");
      }

      $value = $this->container->get($this->middleware_classes[$value]);
    });
    return $middleware;
  }


  function handle(Request $request): Response {
    $params = $this->getParamsFromRoute($this->routes, $request);

    $controllerName = $this->getControllerName($params);
    $controller = $this->container->get($controllerName);
    $controller->setResponse($this->container->get(Response::class));
    $controller->setViewer($this->container->get(TemplateInterface::class));

    $action = $this->getActionName($params);
    $args = $this->getActionArguments($controllerName, $action, $params);
    
    $controller_handler = new ControllerRequestHandler($controller, $action, $args);

    $middleware = $this->getMiddleware($params);

    $middleware_handler = new MiddlewareRequestHandler($middleware, $controller_handler);
    return $middleware_handler->handle($request);
  }

}