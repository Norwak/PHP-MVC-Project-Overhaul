<?php
declare(strict_types=1);
namespace Framework;

class Core {

  private function loadDotenv(): void {
    $dotenv = new Dotenv(ROOT_PATH . '/.env');
    $dotenv->load();
  }


  private function setErrorHandling(): void {
    $exception_output_pipe = new ExceptionOutputPipe();
    set_error_handler([$exception_output_pipe, 'convertErrorToException']);
    set_exception_handler([$exception_output_pipe, 'showException']);
  }


  private function loadConfigs(): array {
    $routes = require ROOT_PATH . '/config/routes.php';
    $dependency_registry = require ROOT_PATH . '/config/services.php';
    $middleware = require ROOT_PATH . '/config/middleware.php';

    return [$routes, $dependency_registry, $middleware];
  }


  private function loadRouteParams(array $routes, Request $request): object {
    $method = $request->method();

    foreach ($routes as $route) {
      if ($route->matches($request)) {
        $params = $route->params();
        break;
      };
    }
    if (!$params) {
      http_response_code(404);
      throw new NotFoundException("No route matched for '$path' with method '{$method}'");
    }

    foreach (['controller', 'action', 'middleware', 'method', 'namespace'] as $property) {
      $$property = '';
      if (array_key_exists($property, $params)) {
        $$property = $params[$property];
        unset($params[$property]);
      };
    }

    return new RouteParams($controller, $action, $middleware, $method, $namespace, $params);
  }


  private function dispatch(RouteParams $route_params, DependencyRegistry $dependency_registry, array $middleware_classes, Request $request) {
    $controller_factory = new ControllerFactory($dependency_registry);
    $controller = $controller_factory->create($route_params->controllerName(), $route_params->namespace());

    $action = new Action($controller, $route_params->action(), $route_params->extra());
    $args = $action->getArguments();

    $middleware_chain = new MiddlewareChain($route_params->middleware_chain(), $middleware_classes, $dependency_registry);
        
    $controller_wrap = new ControllerRequestWrap($controller, $route_params->action(), $args);
    $middleware_wrap = new MiddlewareRequestWrap($middleware_chain->form(), $controller_wrap);

    return $middleware_wrap->handle($request);
  }


  private function respond(array $response_args): void {
    $response = new Response(...$response_args);
    $response->send();
  }


  function start(): void {
    $this->loadDotenv();

    $this->setErrorHandling();

    list($routes, $dependency_registry, $middleware_classes) = $this->loadConfigs();

    $request = $dependency_registry->getOrResolve(Request::class);

    $route_params = $this->loadRouteParams($routes, $request);

    $response_args = $this->dispatch($route_params, $dependency_registry, $middleware_classes, $request);

    $this->respond($response_args);
  }

}