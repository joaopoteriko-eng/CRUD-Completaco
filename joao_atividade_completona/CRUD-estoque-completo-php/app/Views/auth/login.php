<?php

use App\Core\Csrf; ?>
<div class="login-container">
    <div class="card shadow p-4 login-card">
        <h1 class="h3">Acesso ao Estoque MVC</h1>
        <p class="text-secondary">Digite e-mail e senha.</p>
        <form method="post" action="<?= e(url('login.submit')) ?>" class="needs-validation" novalidate><?= Csrf::field() ?>
            <label class="form-label" for="email">E-mail</label><input class="form-control mb-3" id="email" type="email" name="email" required autocomplete="username">
            <label class="form-label" for="senha">Senha</label>
            <div class="input-group mb-3"><input class="form-control" id="senha" type="password" name="senha" required autocomplete="current-password"><button class="btn btn-outline-secondary" type="button" data-toggle-password="senha">Mostrar</button></div>
            <button class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>
</div>