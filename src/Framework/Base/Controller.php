<?php
declare(strict_types=1);
namespace Framework\Base;
use Framework\Request;
use Framework\Response;
use Framework\Interfaces\TemplateInterface;
use ReflectionClass;

abstract class Controller {

  protected Request $request;
  protected Response $response;
  protected TemplateInterface $viewer;


  protected function view(string $template, array $data = []): string {
    $child_controller_dirpath = dirname((new ReflectionClass(static::class))->getFileName());
    $template = $child_controller_dirpath . '/views/' . $template . '.view.php';
    
    return $this->viewer->render($template, $data);
  }


  protected function redirect(string $url): Response {
    header("Location: $url");
    exit();
  }


  function setRequest(Request $request): void {
    $this->request = $request;
  }


  function setResponse(Response $response): void {
    $this->response = $response;
  }


  function setViewer(TemplateInterface $viewer): void {
    $this->viewer = $viewer;
  }

}