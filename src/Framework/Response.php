<?php
declare(strict_types=1);
namespace Framework;

class Response {

  private string $body = '';
  private array $headers = [];
  private int $status_code = 0;


  function getBody(): string {
    return $this->body;
  }


  function setBody(string $body): void {
    $this->body = $body;
  }


  function addHeader(string $header): void {
    $this->headers[] = $header;
  }


  function setStatus(int $status_code): void {
    $this->status_code = $status_code;
  }


  function redirect(string $url): void {
    $this->addHeader("Location: $url");
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