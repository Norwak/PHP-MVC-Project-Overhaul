<?php

declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestHandlerInterface;
use Framework\Interfaces\MiddlewareInterface;

class ChangeRequestExample implements MiddlewareInterface {

  function process(Request $request, RequestHandlerInterface $next): Response {
    // won't work because i made Request immutable
    // $request->post = array_map('trim', $request->post);
    
    $response = $next->handle($request);

    return $response;
  }

}