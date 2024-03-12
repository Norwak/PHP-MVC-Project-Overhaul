<?php

declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestWrapInterface;
use Framework\Interfaces\MiddlewareInterface;

class ChangeRequestExample implements MiddlewareInterface {

  function process(Request $request, RequestWrapInterface $next): array {
    // won't work because i made Request immutable
    // $request->post = array_map('trim', $request->post);
    
    $body = $next->handle($request);

    return $body;
  }

}