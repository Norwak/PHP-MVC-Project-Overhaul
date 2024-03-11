<?php
use App\Database;
use Framework\Interfaces\TemplateInterface;

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
  }
]);