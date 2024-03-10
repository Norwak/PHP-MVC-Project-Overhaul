<?php
declare(strict_types=1);
namespace App\Modules\Products;
use App\Models\Product;
use Framework\Exceptions\NotFoundException;
use Framework\Controller;
use Framework\Response;

class ProductsController extends Controller {

  function __construct(
    private ProductsModel $model,
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

    return $this->view('index', [
      "products" => $products,
      "total" => $this->model->getTotal(),
    ]);
  }


  function show(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('show', [
      "product" => $product
    ]);
  }


  function showPage(string $title, string $id, string $page) {
    echo $title, " ", $id, " ", $page;
    return $this->response;
  }


  function new(): Response {
    return $this->view('new');
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
      return $this->view('new', [
        "errors" => $this->model->getErrors(),
        "product" => $data,
      ]);
    };
  }


  function edit(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('edit', [
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
  
      return $this->view('edit', [
        "errors" => $this->model->getErrors(),
        "product" => $product
      ]);
    };
  }


  function delete(string $id): Response {
    $product = $this->getProduct($id);

    return $this->view('delete', [
      "product" => $product
    ]);
  }


  function remove(string $id): Response {
    $product = $this->getProduct($id);

    $this->model->remove($id);
    return $this->redirect('/products');
  }

}