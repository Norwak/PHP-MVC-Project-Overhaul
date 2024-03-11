<?php
declare(strict_types=1);
namespace Framework;

class Response {

  function __construct(
    private string $body = '',
    private array $headers = [],
    private int $status_code = 200,
  ) {}


  function redirect(string $url): void {
    $this->headers = ["Location: $url"];
    $this->status_code = 301;
  }


  function send(): void {
    if ($this->status_code) {
      http_response_code($this->status_code);
    }

    foreach ($this->headers as $header) {
      header($header);
    }

    echo $this->body;
  }

}