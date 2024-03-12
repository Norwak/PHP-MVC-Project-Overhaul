<?php
namespace Framework\Interfaces;
use Framework\Request;
use Framework\Response;

interface RequestWrapInterface {

  function handle(Request $request): array;

}