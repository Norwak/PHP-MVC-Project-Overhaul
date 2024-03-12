<?php
declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestWrapInterface;
use Framework\Interfaces\MiddlewareInterface;

class RedirectExapmle implements MiddlewareInterface {

  function process(Request $request, RequestWrapInterface $next): array {
    $body = '';
    $headers = ['Location: /products/index'];
    $status = 301;
    return [
      'body' => $body,
      'headers' => $headers,
      'status_code' => $status,
    ];
  }

}