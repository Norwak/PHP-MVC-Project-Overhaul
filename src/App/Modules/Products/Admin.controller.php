<?php
namespace App\Modules\Products;
use Framework\Base\Controller;

class Admin extends Controller {

  function index(): string {
    return $this->view('admin');
  }

}