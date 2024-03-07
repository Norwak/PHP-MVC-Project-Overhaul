<?php
declare(strict_types=1);
namespace App\Controllers;
use Framework\Controller;

class Home extends Controller {

  function index() {
    echo $this->viewer->render('shared/header.php', [
      "title" => "Homepage"
    ]);

    echo $this->viewer->render('Home/index.php');
  }

}