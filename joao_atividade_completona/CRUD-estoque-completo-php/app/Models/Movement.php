<?php

namespace App\Models;

use App\Core\Database;
use RuntimeException;
use Throwable;

final class Movement
{
    public function recent(int $limit = 100, string $tipo = ''): array
    {
        // LIMIT não recebe entrada do usuário: o argumento é fixado no controller.
        $sql = 'SELECT m.*,p.nome produto,u.nome responsavel FROM movimentacoes m JOIN produtos p ON p.id=m.produto_id JOIN usuarios u ON u.id=m.usuario_id';
        $args = [];
        if (in_array($tipo, ['entrada', 'saida'], true)) {
            $sql .= ' WHERE m.tipo=?';
            $args[] = $tipo;
        }
        $sql .= ' ORDER BY m.id DESC LIMIT ' . max(1, min(100, $limit));
        $s = Database::connection()->prepare($sql);
        $s->execute($args);
        return $s->fetchAll();
    }
    public function record(int $productId, int $userId, string $type, int $qty, string $note): void
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();
        try {
            $s = $pdo->prepare('SELECT quantidade FROM produtos WHERE id=? FOR UPDATE');
            $s->execute([$productId]);
            $product = $s->fetch();
            if (!$product) throw new RuntimeException('Produto não encontrado.');
            $saldo = (int)$product['quantidade'];
            if ($type === 'saida' && $qty > $saldo) throw new RuntimeException('Estoque insuficiente.');
            if ($type === 'entrada' && $qty > 4294967295 - $saldo) throw new RuntimeException('Limite do estoque ultrapassado.');
            $novo = $type === 'entrada' ? $saldo + $qty : $saldo - $qty;
            $s = $pdo->prepare('UPDATE produtos SET quantidade=? WHERE id=?');
            $s->execute([$novo, $productId]);
            $s = $pdo->prepare('INSERT INTO movimentacoes(produto_id,usuario_id,tipo,quantidade,observacao) VALUES(?,?,?,?,?)');
            $s->execute([$productId, $userId, $type, $qty, $note === '' ? null : $note]);
            $pdo->commit();
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }
}
