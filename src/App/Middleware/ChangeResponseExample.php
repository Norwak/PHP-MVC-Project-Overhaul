<?php

declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestHandlerInterface;
use Framework\Interfaces\MiddlewareInterface;

class ChangeResponseExample implements MiddlewareInterface {

  function process(Request $request, RequestHandlerInterface $next): Response {
    $response = $next->handle($request);

    $response->setBody($response->getBody() . " hello from the middleware");

    return $response;
  }

}