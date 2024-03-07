<?php
declare(strict_types=1);
namespace Framework;

interface MiddlewareInterface {

  function process(Request $request, RequestHandlerInterface $next): Response;

}