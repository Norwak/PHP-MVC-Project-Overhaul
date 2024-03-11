<?php
declare(strict_types=1);
namespace App\Middleware;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\RequestHandlerInterface;
use Framework\Interfaces\MiddlewareInterface;

class RedirectExapmle implements MiddlewareInterface {

  function __construct(
    private Response $response
  ) {}


  function process(Request $request, RequestHandlerInterface $next): string {
    $this->response->redirect('/products/index');
    return $this->response;
  }

}