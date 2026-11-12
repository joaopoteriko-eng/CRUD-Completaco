<?php

namespace App\Core;

use App\Models\User;

final class Auth
{
   public static function user(): ?array
   {
      $id = positiveId($_SESSION['user_id'] ?? null);
      if (!$id) return null;
      // A cada request, verifica o perfil/ativo no banco: desativação tem efeito imediato.
      $u = (new User())->find($id);
      if (!$u || !(int)$u['ativo']) {
         unset($_SESSION['user_id']);
         return null;
      }
      return $u;
   }
   public static function requireLogin(): array
   {
      $u = self::user();
      if (!$u) go('login');
      return $u;
   }
   public static function requireAdmin(): array
   {
      $u = self::requireLogin();
      if ($u['perfil'] !== 'admin') {
         http_response_code(403);
         exit('Acesso negado: requer administrador.');
      }
      return $u;
   }
   public static function login(int $id): void
   {
      session_regenerate_id(true);
      $_SESSION['user_id'] = $id;
      $_SESSION['csrf'] = bin2hex(random_bytes(32));
   }
   public static function logout(): void
   {
      $_SESSION = [];
      if (ini_get('session.use_cookies')) {
         $p = session_get_cookie_params();
         setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
      }
      session_destroy();
   }
}
