<?php
namespace App\Modules\Products;
use Framework\Controller;

class Admin extends Controller {

  function index() {
    return $this->view('admin');
  }

}