<?php
namespace App\Modules\UserAdmin2;
use Framework\Controller;
use Framework\Response;

class UserAdmin2Controller extends Controller {

  function showList(): Response {
    echo 'Hello from the showList method';
    return $this->response;
  }

}