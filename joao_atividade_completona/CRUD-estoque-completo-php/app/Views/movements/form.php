<?php

use App\Core\Csrf; ?>
<h1 class="h3">Movimentar estoque</h1>
<p>Produto: <strong><?= e($product['nome']) ?></strong> • Saldo atual: <?= (int)$product['quantidade'] ?></p>
<form class="card card-body shadow-sm needs-validation" novalidate method="post" action="<?= e(url('movements.save')) ?>"><?= Csrf::field() ?><input type="hidden" name="produto_id" value="<?= (int)$product['id'] ?>">
    <div class="mb-3"><label for="tipo" class="form-label">Tipo</label><select id="tipo" name="tipo" class="form-select">
            <option value="entrada">Entrada (+)</option>
            <option value="saida">Saída (-)</option>
        </select></div>
    <div class="mb-3"><label for="quantidade" class="form-label">Quantidade</label><input class="form-control" id="quantidade" name="quantidade" type="number" min="1" step="1" required></div>
    <div class="mb-3"><label for="observacao" class="form-label">Observação</label><textarea class="form-control" id="observacao" name="observacao" maxlength="255" data-counter="contador"></textarea><small id="contador" class="text-secondary">0/255</small></div>
    <div class="alert alert-info">Prévia: <strong id="saldo-previa" data-saldo="<?= (int)$product['quantidade'] ?>">—</strong></div>
    <button class="btn btn-primary">Confirmar</button>
</form>