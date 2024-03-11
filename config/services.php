<?php
use App\Database;
use Framework\Interfaces\TemplateInterface;
use Framework\Request;

return new Framework\DependencyRegistry([
  Database::class => function() {
    $host = $_ENV['DB_HOST'];
    $db = $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    return new Database($host, $db, $user, $password);
  },

  TemplateInterface::class => function() {
    return new Framework\TemplateEngine();
  },

  Request::class => function() {
    $uri = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];
    return new Framework\Request($uri, $method, $_GET, $_POST, $_FILES, $_COOKIE, $_SERVER);
  }
]);