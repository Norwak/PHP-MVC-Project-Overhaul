<?php

$container = new Framework\Container();

$container->set(App\Database::class, function() {
  $host = $_ENV['DB_HOST'];
  $db = $_ENV['DB_NAME'];
  $user = $_ENV['DB_USER'];
  $password = $_ENV['DB_PASS'];
  return new App\Database($host, $db, $user, $password);
});

$container->set(Framework\TemplateInterface::class, function() {
  return new Framework\TemplateEngine();
});

return $container;