<?php
namespace Framework\Interfaces;
use Framework\Request;
use Framework\Response;

interface MiddlewareInterface {

  function process(Request $request, RequestWrapInterface $next): array;

}