<?php
use Framework\Route;

return $routes = [
  new Route('/admin/{controller}/{action}', [
    "namespace" => "Admin",
  ]),
  new Route('/{title}/{id:\d+}/{page:\d+}', [
    "controller" => "products",
    "action" => "showPage",
  ]),
  new Route('/product/{slug:[\w-]+}', [
    "controller" => "products",
    "action" => "show",
  ]),

  new Route('/{controller}/{id:\d+}/show', [
    "action" => "show",
    "middleware" => "message|message",
  ]),
  new Route('/{controller}/{id:\d+}/edit', [
    "action" => "edit",
  ]),
  new Route('/{controller}/{id:\d+}/update', [
    "action" => "update",
  ]),
  new Route('/{controller}/{id:\d+}/delete', [
    "action" => "delete",
  ]),
  new Route('/{controller}/{id:\d+}/remove', [
    "action" => "remove",
    "method" => "post",
  ]),

  new Route('/products', [
    "controller" => "products",
    "action" => "index"
  ]),

  new Route('/home/index', [
    "controller" => "home",
    "action" => "index"
  ]),
  new Route('/', [
    "controller" => "home",
    "action" => "index"
  ]),

  new Route('/{controller}/{action}'),
];