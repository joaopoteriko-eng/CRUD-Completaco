<?php

namespace App\Models;

use App\Core\Database;

final class Product
{
    public function all(string $search = ''): array
    {
        $s = Database::connection()->prepare('SELECT * FROM produtos WHERE nome LIKE ? OR categoria LIKE ? ORDER BY nome');
        $s->execute(['%' . $search . '%', '%' . $search . '%']);
        return $s->fetchAll();
    }
    public function find(int $id): ?array
    {
        $s = Database::connection()->prepare('SELECT * FROM produtos WHERE id=?');
        $s->execute([$id]);
        return $s->fetch() ?: null;
    }
    public function create(string $nome, string $categoria, string $preco): void
    {
        $s = Database::connection()->prepare('INSERT INTO produtos(nome,categoria,preco,quantidade) VALUES(?,?,?,0)');
        $s->execute([$nome, $categoria, $preco]);
    }
    public function update(int $id, string $nome, string $categoria, string $preco): void
    {
        $s = Database::connection()->prepare('UPDATE produtos SET nome=?,categoria=?,preco=? WHERE id=?');
        $s->execute([$nome, $categoria, $preco, $id]);
    }
    public function delete(int $id): bool
    {
        $s = Database::connection()->prepare('DELETE FROM produtos WHERE id=? AND quantidade=0');
        $s->execute([$id]);
        return $s->rowCount() > 0;
    }
    public function stats(): array
    {
        return Database::connection()->query('SELECT COUNT(*) total_produtos,COALESCE(SUM(quantidade),0) unidades,COALESCE(SUM(preco*quantidade),0) valor,COALESCE(SUM(CASE WHEN quantidade<=5 THEN 1 ELSE 0 END),0) baixos FROM produtos')->fetch();
    }
}
