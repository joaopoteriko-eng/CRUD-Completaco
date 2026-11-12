<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\Movement;
use App\Models\Product;
use RuntimeException;

final class MovementController
{
    public function index(): void
    {
        Auth::requireLogin();
        $tipo = (string)($_GET['tipo'] ?? '');
        if (!in_array($tipo, ['entrada', 'saida'], true)) $tipo = '';
        View::render('movements/index', ['title' => 'Histórico', 'type' => $tipo, 'items' => (new Movement())->recent(100, $tipo)]);
    }
    public function form(): void
    {
        Auth::requireLogin();
        $id = positiveId($_GET['produto_id'] ?? null);
        $product = $id ? (new Product())->find($id) : null;
        if (!$product) {
            http_response_code(404);
            exit('Produto não encontrado.');
        }
        View::render('movements/form', ['title' => 'Movimentar estoque', 'product' => $product]);
    }
    public function save(): void
    {
        $u = Auth::requireLogin();
        Csrf::verify();
        $product = positiveId($_POST['produto_id'] ?? null);
        $qty = positiveId($_POST['quantidade'] ?? null);
        $type = (string)($_POST['tipo'] ?? '');
        $note = trim((string)($_POST['observacao'] ?? ''));
        if (!$product || !$qty || !in_array($type, ['entrada', 'saida'], true) || mb_strlen($note) > 255) {
            flash('danger', 'Movimentação inválida.');
            go('products');
        }
        try {
            (new Movement())->record($product, (int)$u['id'], $type, $qty, $note);
            flash('success', 'Movimentação registrada com sucesso.');
        } catch (RuntimeException $e) {
            flash('warning', $e->getMessage());
        }
        go('movements');
    }
}
