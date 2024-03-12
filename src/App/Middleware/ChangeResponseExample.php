<?php

declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestWrapInterface;
use Framework\Interfaces\MiddlewareInterface;

class ChangeResponseExample implements MiddlewareInterface {

  function process(Request $request, RequestWrapInterface $next): array {
    $response_args = $next->handle($request);

    $response_args['body'] .= " hello from the middleware";

    return $response_args;
  }

}