<?php
declare(strict_types=1);
namespace Framework;
use UnexpectedValueException;
use BadRequestException;

class Request {

  function __construct(
    private string $uri,
    private string $method,
    private array $get,
    private array $post,
    private array $files,
    private array $cookie,
    private array $server,
  ) {}


  function path(): string {
    $path = parse_url($this->uri, PHP_URL_PATH);

    if ($path === false) {
      throw new UnexpectedValueException("Malformed URL: '{$this->uri}'");
    }

    return $path ?? '/';
  }

  
  function method(): string {
    if (!in_array($this->method, ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'])) {
      throw new BadRequestException("Unsupported method: '$this->method'");
    }

    return $this->method ?? 'GET';
  }


  function get(): array {
    return $this->get;
  }


  function post(): array {
    return $this->post;
  }


  function files(): array {
    return $this->files;
  }


  function cookie(): array {
    return $this->cookie;
  }


  function server(): array {
    return $this->server;
  }

}