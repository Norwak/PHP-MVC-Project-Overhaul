<?php
declare(strict_types=1);
namespace App\Modules\Home;
use Framework\Base\Controller;
use Framework\Response;

class HomeController extends Controller {

  function index(): Response {
    return $this->view('index');
  }

}