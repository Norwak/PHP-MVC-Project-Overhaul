<?php
namespace Framework\Interfaces;
use Framework\Request;
use Framework\Response;

interface MiddlewareInterface {

  function process(Request $request, RequestHandlerInterface $next): array;

}