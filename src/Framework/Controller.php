<?php
declare(strict_types=1);
namespace Framework;
use Framework\Request;
use Framework\Response;

abstract class Controller {

  protected Request $request;
  protected Response $response;
  protected TemplateInterface $viewer;


  protected function view(string $template, array $data = []): Response {
    $this->response->setBody($this->viewer->render($template, $data));
    return $this->response;
  }


  protected function redirect(string $url): Response {
    $this->response->redirect($url);
    return $this->response;
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