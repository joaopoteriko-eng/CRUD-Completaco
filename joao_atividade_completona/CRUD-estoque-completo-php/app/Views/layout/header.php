<?php

use App\Core\Auth;
use App\Core\Csrf;

$current = Auth::user();
?>
<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?= e($title ?? 'Estoque Didático MVC') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/estilo.css">
</head>

<body>
    <?php if (empty($guest)): ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
            <div class="container">
                <a class="navbar-brand" href="<?= e(url('dashboard')) ?>">📦 Estoque MVC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-label="Alternar menu"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="menu">
                    <div class="navbar-nav me-auto">
                        <a class="nav-link" href="<?= e(url('dashboard')) ?>">Dashboard</a>
                        <a class="nav-link" href="<?= e(url('products')) ?>">Produtos</a>
                        <a class="nav-link" href="<?= e(url('movements')) ?>">Histórico</a>
                        <?php if ($current && $current['perfil'] === 'admin'): ?><a class="nav-link" href="<?= e(url('users')) ?>">Usuários</a><?php endif; ?>
                        <a class="nav-link" href="<?= e(url('password')) ?>">Minha senha</a>
                    </div>
                    <span class="navbar-text text-white me-3"><?= e($current['nome'] ?? '') ?> (<?= e($current['perfil'] ?? '') ?>)</span>
                    <form method="post" action="<?= e(url('logout')) ?>" class="m-0"><?= Csrf::field() ?><button class="btn btn-outline-light btn-sm">Sair</button></form>
                </div>
            </div>
        </nav><?php endif; ?>
    <main class="container pb-5">
        <?php $flash = takeFlash();
        if ($flash): ?>
            <div class="alert alert-<?= e(in_array($flash['type'], ['success', 'danger', 'warning', 'info'], true) ? $flash['type'] : 'info') ?> alert-dismissible fade show" role="alert"><?= e($flash['message']) ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button></div>
        <?php endif; ?>