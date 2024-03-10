<?php
namespace Framework\Interfaces;

interface TemplateInterface {

  function render(string $template, array $data = []): string;

}