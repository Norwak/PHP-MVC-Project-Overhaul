<?php
declare(strict_types=1);
namespace Framework;

class Route {

  private string $pattern;
  private array $params;


  function __construct(string $route_path, array $params = []) {
    $this->pattern = $this->getPatternFromRoutePath($route_path);
    $this->params = $params;
  }


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
  

  function match(string $path, string $method): array {
    $path = urldecode($path);
    $path = trim($path, '/');

    if (!preg_match($this->pattern, $path, $matches)) return [];

    $matches = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
    $params = array_merge($matches, $this->params);

    if (array_key_exists("method", $params)) {
      if (strtolower($method) !== strtolower($params['method'])) return [];
    }

    return $params;
  }
}