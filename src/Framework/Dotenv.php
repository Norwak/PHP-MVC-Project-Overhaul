<?php
declare(strict_types=1);

namespace Framework;

class Dotenv {

  function __construct(
    private string $path,
  ) {}

  function load(): void {
    $lines = file($this->path, FILE_IGNORE_NEW_LINES);

    foreach ($lines as $line) {
      list($name, $value) = explode("=", $line, 2);
      $_ENV[$name] = $value;
    }
  }

}