<?php
namespace Framework\Interfaces;
use Framework\Request;
use Framework\Response;

interface RequestHandlerInterface {

  function handle(Request $request): array;

}