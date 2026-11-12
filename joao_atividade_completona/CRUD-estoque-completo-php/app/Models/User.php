<?php

namespace App\Models;

use App\Core\Database;
use PDO;

final class User
{
    public function byEmail(string $email): ?array
    {
        $s = Database::connection()->prepare('SELECT * FROM usuarios WHERE email=? LIMIT 1');
        $s->execute([$email]);
        return $s->fetch() ?: null;
    }
    public function find(int $id): ?array
    {
        $s = Database::connection()->prepare('SELECT * FROM usuarios WHERE id=?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }
    public function all(): array
    {
        return Database::connection()->query('SELECT id,nome,email,perfil,ativo,criado_em FROM usuarios ORDER BY id')->fetchAll();
    }
    public function create(string $nome, string $email, string $senha, string $perfil): void
    {
        $s = Database::connection()->prepare('INSERT INTO usuarios(nome,email,senha_hash,perfil) VALUES(?,?,?,?)');
        $s->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT), $perfil]);
    }
    public function changePassword(int $id, string $password): void
    {
        $s = Database::connection()->prepare('UPDATE usuarios SET senha_hash=? WHERE id=?');
        $s->execute([password_hash($password, PASSWORD_DEFAULT), $id]);
    }
    public function toggle(int $id): void
    {
        $s = Database::connection()->prepare('UPDATE usuarios SET ativo=IF(ativo=1,0,1) WHERE id=?');
        $s->execute([$id]);
    }
}
