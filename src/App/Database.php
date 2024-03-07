<?php
namespace App;
use PDO;

class Database {

  private ?PDO $pdo = null;


  function __construct(
    private string $host,
    private string $db,
    private string $user,
    private string $pass,
  ) {}


  function getConnection(): PDO {
    $charset = 'utf8mb4';

    if (!$this->pdo) {
      $data_source = "mysql:host={$this->host};dbname={$this->db};charset=$charset";
      $options = [
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES   => false,
      ];
  
      $this->pdo = new PDO($data_source, $this->user, $this->pass, $options);
    }

    return $this->pdo;
  }

}