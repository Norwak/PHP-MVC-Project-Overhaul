<?php
declare(strict_types=1);
namespace Framework;
use ErrorException;
use Throwable;
use Framework\Exceptions\NotFoundException;

class ErrorHandler {

  static function handleError(int $errno, string $errstr, string $errfile, int $errline): bool {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
  }


  static function handleException(Throwable $exception): void {

    if ($exception instanceof NotFoundException) {
      http_response_code(404);
      $template = '404.php';
    } else {
      http_response_code(500);
      $template = '500.php';
    }
  
    $show_errors = $_ENV['SHOW_ERRORS'] === 'true';
  
    if ($show_errors) {
      ini_set('display_errors', '1');
    } else {
      ini_set('display_errors', '0');
      ini_set('log_errors', '1');
      require dirname(__DIR__, 2) . "/views/$template";
    }
  
    throw $exception;
  }

}