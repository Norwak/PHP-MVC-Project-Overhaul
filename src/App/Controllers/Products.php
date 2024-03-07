<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Models\Product;
use Framework\Exceptions\NotFoundException;
use Framework\Controller;
use Framework\Response;

class Products extends Controller {

  function __construct(
    private Product $model,
  ) {}


  private function getProduct(string $id): array {
    $product = $this->model->find($id);

    if (!$product) {
      throw new NotFoundException('Product not found');
    }

    return $product;
  }


  function index(): Response {
    $products = $this->model->findAll();

    return $this->view('Products/index.engine.php', [
      "products" => $products,
      "total" => $this->model->getTotal(),
    ]);
  }


  function show(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('Products/show.engine.php', [
      "product" => $product
    ]);
  }


  function showPage(string $title, string $id, string $page) {
    echo $title, " ", $id, " ", $page;
  }


  function new(): Response {
    return $this->view('Products/new.engine.php');
  }


  function create(): Response { 
    $post = $this->request->post();

    $data = [
      "name" => $post['name'],
      "description" => $post['description'] ?: null,
    ];

    $result = $this->model->create($data);
    if ($result) {
      return $this->redirect("/products/{$result['id']}/show");
    } else {
      return $this->view('Products/new.engine.php', [
        "errors" => $this->model->getErrors(),
        "product" => $data,
      ]);
    };
  }


  function edit(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('Products/edit.engine.php', [
      "product" => $product
    ]);
  }


  function update(string $id): Response {
    $post = $this->request->post();

    $product['name'] = $post['name'];
    $product['description'] = $post['description'] ?: null;

    $result = $this->model->update($id, $product);
    if ($result) {
      return $this->redirect("/products/{$result['id']}/show");
    } else {
      $product['id'] = $id;
  
      return $this->view('Products/edit.engine.php', [
        "errors" => $this->model->getErrors(),
        "product" => $product
      ]);
    };
  }


  function delete(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('Products/delete.engine.php', [
      "product" => $product
    ]);
  }


  function remove(string $id): Response {
    $product = $this->getProduct($id);

    $this->model->remove($id);
    return $this->redirect('/products');
  }

}