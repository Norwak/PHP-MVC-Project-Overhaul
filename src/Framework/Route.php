<?php
declare(strict_types=1);
namespace Framework;

class Route {

  function __construct(
    private string $path,
    private array $params = [],
  ) {}


  private function getPatternFromRoutePath(string $route_path): string {
    $route_path = trim($route_path, '/');
    $segments = explode('/', $route_path);

    $segments = array_map(function(string $segment): string {
      if (preg_match('#^\{([a-z][a-z0-9]*)\}$#', $segment, $matches)) {
        return '(?<' . $matches[1] . '>[^/]*)';
      };
      
      if (preg_match('#^\{([a-z][a-z0-9]*):(.+)\}$#', $segment, $matches)) {
        return '(?<' . $matches[1] . '>' . $matches[2] . ')';
      };

      return $segment;
    }, $segments);

    return '#^' . implode('/', $segments) . '$#iu';
  }
  

  function matches(Request $request): bool {
    $path = $request->path();
    $method = $request->method();
    
    $path = urldecode($path);
    $path = trim($path, '/');

    $pattern = $this->getPatternFromRoutePath($this->path);
    if (!preg_match($pattern, $path, $matches)) return false;
    
    $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    $params = array_merge($matches, $this->params);
    $this->params = $params;

    if (array_key_exists("method", $params)) {
      if (strtolower($method) !== strtolower($params['method'])) return false;
    }

    return true;
  }
  

  function params(): array {
    return $this->params;
  }
}