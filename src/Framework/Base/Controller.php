<?php
declare(strict_types=1);
namespace Framework\Base;
use Framework\Request;
use Framework\Interfaces\TemplateInterface;
use ReflectionClass;

abstract class Controller {

  function __construct(
    protected Request $request,
    protected TemplateInterface $viewer,
  ) {}


  protected function loadView(string $template, array $data = []): array {
    $child_controller_dirpath = dirname((new ReflectionClass($this::class))->getFileName());
    $template = $child_controller_dirpath . '/views/' . $template . '.view.php';
    
    $body = $this->viewer->render($template, $data); 
    return [
      'body' => $body
    ];
  }


  protected function showHTML(string $HTML): array {
    $body = $HTML; 
    return [
      'body' => $body
    ];
  }


  protected function redirect(string $url): array {
    $body = '';
    $headers = ["Location: $url"];
    $status = 301;
    return [
      'body' => $body,
      'headers' => $headers,
      'status_code' => $status
    ];
  }

}