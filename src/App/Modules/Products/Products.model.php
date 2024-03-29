<?php
declare(strict_types=1);
namespace App\Modules\Products;
use Framework\Base\Model;
use Framework\Exceptions\NotFoundException;

class ProductsModel extends Model {

  // protected $table = 'products';


  protected function validate(array $data): void {
    if (empty($data['name'])) {
      $this->addError('name', 'Name is required');
    };
  }


  function getTotal(): int {
    $pdo = $this->database->getConnection();

    $sql = "SELECT COUNT(*) AS total FROM products";
    $stmt = $pdo->query($sql);

    $row = $stmt->fetch();
    return (int) $row['total'];
  }


  function getProduct(string $id): array {
    $product = $this->find($id);

    if (!$product) {
      throw new NotFoundException('Product not found');
    }

    return $product;
  }

}