<?php
declare(strict_types=1);
namespace App\Modules\Products;
use App\Models\Product;
use Framework\Exceptions\NotFoundException;
use Framework\Base\Controller;
use Framework\Request;
use Framework\Interfaces\TemplateInterface;

class ProductsController extends Controller {

  function __construct(
    protected Request $request,
    protected TemplateInterface $viewer,
    private ProductsModel $model,
  ) {
    parent::__construct(...func_get_args());
  }


  private function getProduct(string $id): array {
    $product = $this->model->find($id);

    if (!$product) {
      throw new NotFoundException('Product not found');
    }

    return $product;
  }


  function index(): array {
    $products = $this->model->findAll();

    return $this->loadView('index', [
      "products" => $products,
      "total" => $this->model->getTotal(),
    ]);
  }


  function show(string $id): array {
    $get = $this->request->get();
    $product = $this->getProduct($id);

    return $this->loadView('show', [
      "product" => $product
    ]);
  }


  function showPage(string $title, string $id, string $page): array {
    return $this->showHTML($title . " " . $id . " " . $page);
  }


  function new(): array {
    return $this->loadView('new');
  }


  function create(): array { 
    $post = $this->request->post();

    $data = [
      "name" => $post['name'],
      "description" => $post['description'] ?: null,
    ];

    $result = $this->model->create($data);
    if ($result) {
      return $this->redirect("/products/{$result['id']}/show");
    } else {
      return $this->loadView('new', [
        "errors" => $this->model->getErrors(),
        "product" => $data,
      ]);
    };
  }


  function edit(string $id): array {
    $product = $this->getProduct($id);

    return $this->loadView('edit', [
      "product" => $product
    ]);
  }


  function update(string $id): array {
    $post = $this->request->post();

    $product['name'] = $post['name'];
    $product['description'] = $post['description'] ?: null;

    $result = $this->model->update($id, $product);
    if ($result) {
      return $this->redirect("/products/{$result['id']}/show");
    } else {
      $product['id'] = $id;
  
      return $this->loadView('edit', [
        "errors" => $this->model->getErrors(),
        "product" => $product
      ]);
    };
  }


  function delete(string $id): array {
    $product = $this->getProduct($id);

    return $this->loadView('delete', [
      "product" => $product
    ]);
  }


  function remove(string $id): array {
    $product = $this->getProduct($id);

    $this->model->remove($id);
    return $this->redirect('/products');
  }

}