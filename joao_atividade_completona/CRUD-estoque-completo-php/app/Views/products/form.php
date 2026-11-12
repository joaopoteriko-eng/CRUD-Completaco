<?php

use App\Core\Csrf; ?>
<h1 class="h3"><?= e($title) ?></h1>
<p class="text-secondary">O estoque é alterado somente por entradas e saídas, nunca neste formulário.</p>
<form class="card card-body shadow-sm needs-validation" novalidate method="post" action="<?= e(url('products.save')) ?>"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= e((string)$product['id']) ?>">
    <div class="mb-3"><label class="form-label" for="nome">Nome</label><input class="form-control" id="nome" name="nome" required maxlength="120" value="<?= e($product['nome']) ?>"></div>
    <div class="mb-3"><label class="form-label" for="categoria">Categoria</label><input class="form-control" id="categoria" name="categoria" required maxlength="80" value="<?= e($product['categoria']) ?>"></div>
    <div class="mb-3"><label class="form-label" for="preco">Preço</label><input class="form-control" id="preco" name="preco" required value="<?= e((string)$product['preco']) ?>"></div>
    <button class="btn btn-primary">Salvar</button>
</form>