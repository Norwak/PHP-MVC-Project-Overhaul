<?php
namespace Framework;

interface TemplateInterface {

  function render(string $template, array $data = []): string;

}