<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\Product;
use PDOException;

final class ProductController
{
    public function index(): void
    {
        Auth::requireLogin();
        $search = trim((string)($_GET['busca'] ?? ''));
        View::render('products/index', ['title' => 'Produtos', 'search' => $search, 'products' => (new Product())->all($search)]);
    }
    public function form(): void
    {
        Auth::requireAdmin();
        $id = isset($_GET['id']) ? positiveId($_GET['id']) : null;
        if (isset($_GET['id']) && !$id) {
            http_response_code(400);
            exit('ID inválido.');
        }
        $product = $id ? (new Product())->find($id) : ['id' => '', 'nome' => '', 'categoria' => '', 'preco' => '0.00'];
        if (!$product) {
            http_response_code(404);
            exit('Produto não encontrado.');
        }
        View::render('products/form', ['title' => $id ? 'Editar produto' : 'Novo produto', 'product' => $product]);
    }
    public function save(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        $id = (string)($_POST['id'] ?? '');
        $name = trim((string)($_POST['nome'] ?? ''));
        $category = trim((string)($_POST['categoria'] ?? ''));
        $price = money((string)($_POST['preco'] ?? ''));
        if ($name === '' || mb_strlen($name) > 120 || $category === '' || mb_strlen($category) > 80 || $price === null || ($id !== '' && !positiveId($id))) {
            flash('danger', 'Dados inválidos. Verifique nome, categoria e preço.');
            go('products');
        }
        $model = new Product();
        if ($id !== '') $model->update((int)$id, $name, $category, $price);
        else $model->create($name, $category, $price);
        flash('success', 'Produto salvo. Estoque só muda por movimentação.');
        go('products');
    }
    public function delete(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        $id = positiveId($_POST['id'] ?? null);
        if (!$id) {
            flash('danger', 'ID inválido.');
            go('products');
        }
        try {
            $ok = (new Product())->delete($id);
            flash($ok ? 'success' : 'warning', $ok ? 'Produto excluído.' : 'Produto não encontrado ou possui saldo.');
        } catch (PDOException $e) {
            flash('warning', 'Produto com histórico não pode ser excluído.');
        }
        go('products');
    }
}
