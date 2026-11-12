<?php

namespace App\Core;

final class Csrf
{
  public static function token(): string
  {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
  }
  public static function field(): string
  {
    return '<input type="hidden" name="csrf" value="' . e(self::token()) . '">';
  }
  public static function verify(): void
  {
    if (!hash_equals(self::token(), (string)($_POST['csrf'] ?? ''))) {
      http_response_code(419);
      exit('Token CSRF inválido. Recarregue a página.');
    }
  }
}
