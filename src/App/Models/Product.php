<?php
declare(strict_types=1);
namespace App\Models;
use Framework\Model;

class Product extends Model {

  // protected $table = 'products';


  protected function validate(array $data): void {
    if (empty($data['name'])) {
      $this->addError('name', 'Name is required');
    };
  }


  function getTotal(): int {
    $pdo = $this->database->getConnection();

    $sql = "SELECT COUNT(*) AS total FROM product";
    $stmt = $pdo->query($sql);

    $row = $stmt->fetch();
    return (int) $row['total'];
  }

}