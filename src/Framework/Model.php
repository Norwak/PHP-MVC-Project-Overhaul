<?php
declare(strict_types=1);
namespace Framework;
use PDO;
use App\Database;

abstract class Model {

  protected $table;
  protected array $errors = [];

  function __construct(
    protected Database $database,
  ) {}


  protected function addError(string $field, string $message): void {
    $this->errors[$field] = $message;
  }


  function getErrors() {
    return $this->errors;
  }


  protected function validate(array $data): void {}


  private function getTable(): string {
    if ($this->table !== null) return $this->table;

    $parts = explode("\\", $this::class);
    return strtolower(array_pop($parts));
  }


  function findAll(): array {
    $pdo = $this->database->getConnection();

    $sql = "SELECT * FROM {$this->getTable()}";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
  }


  function find(string $id): array {
    $pdo = $this->database->getConnection();

    $sql = "SELECT * FROM {$this->getTable()} WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetch();
    return ($data) ?: [];
  }


  function create(array $data): array {
    $pdo = $this->database->getConnection();

    $this->validate($data);
    if (!empty($this->errors)) return [];

    $columns = implode(', ', array_keys($data));
    $placeholders = implode(', ', array_fill(0, count($data), '?'));

    $sql = "INSERT INTO {$this->getTable()} ({$columns}) VALUES ({$placeholders})";
    $stmt = $pdo->prepare($sql);

    $i = 1;
    foreach ($data as $value) {
      $type = match(gettype($value)) {
        "boolean" => PDO::PARAM_BOOL,
        "integer" => PDO::PARAM_INT,
        "NULL" => PDO::PARAM_NULL,
        default => PDO::PARAM_STR,
      };

      $stmt->bindValue($i++, $value, $type);
    }

    $stmt->execute();

    return $this->find($pdo->lastInsertId());
  }


  function update(string $id, array $data): array {
    $pdo = $this->database->getConnection();

    $this->validate($data);
    if (!empty($this->errors)) return [];

    $assignments = array_keys($data);
    array_walk($assignments, function(&$value) {
      $value = "$value = ?";
    });
    $assignments = implode(', ', $assignments);

    $sql = "UPDATE {$this->getTable()} SET {$assignments} WHERE id = ?";
    $stmt = $pdo->prepare($sql);

    $i = 1;
    foreach ($data as $value) {
      $type = match(gettype($value)) {
        "boolean" => PDO::PARAM_BOOL,
        "integer" => PDO::PARAM_INT,
        "NULL" => PDO::PARAM_NULL,
        default => PDO::PARAM_STR,
      };

      $stmt->bindValue($i++, $value, $type);
    }
    $stmt->bindValue($i, $id, PDO::PARAM_INT);

    $stmt->execute();

    return $this->find($id);
  }


  function remove(string $id): array {
    $pdo = $this->database->getConnection();

    $item = $this->find($id);
    unset($item['id']);

    $sql = "DELETE FROM {$this->getTable()} WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
      return $item;
    } else {
      return [];
    }
  }

}