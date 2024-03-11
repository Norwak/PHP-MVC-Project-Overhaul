<?php
namespace App\Modules\UserAdmin2;
use Framework\Base\Controller;

class UserAdmin2Controller extends Controller {

  function showList(): array {
    return $this->showHTML('Hello from the showList method');
  }

}