<?php
namespace Framework;

interface RequestHandlerInterface {

  function handle(Request $request): Response;

}