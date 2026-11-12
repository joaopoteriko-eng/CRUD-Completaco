<?php

use App\Core\Auth;
use App\Core\Csrf; ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Produtos</h1><?php if (Auth::user()['perfil'] === 'admin'): ?><a class="btn btn-primary" href="<?= e(url('products.create')) ?>">Novo produto</a><?php endif; ?>
</div>
<form method="get" class="d-flex gap-2 mb-3"><input type="hidden" name="r" value="products"><input name="busca" class="form-control" placeholder="Nome ou categoria" value="<?= e($search) ?>"><button class="btn btn-outline-primary">Buscar</button></form>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Saldo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?><tr>
                    <td><?= e($p['nome']) ?></td>
                    <td><?= e($p['categoria']) ?></td>
                    <td>R$ <?= number_format((float)$p['preco'], 2, ',', '.') ?></td>
                    <td><?= (int)$p['quantidade'] ?></td>
                    <td>
                        <a class="btn btn-sm btn-outline-primary" href="<?= e(url('movements.create', ['produto_id' => $p['id']])) ?>">Movimentar</a>
                        <?php if (Auth::user()['perfil'] === 'admin'): ?>
                            <a class="btn btn-sm btn-outline-secondary" href="<?= e(url('products.edit', ['id' => $p['id']])) ?>">Editar</a>
                            <form method="post" action="<?= e(url('products.delete')) ?>" class="d-inline" data-confirm="Excluir o produto?"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button class="btn btn-sm btn-outline-danger">Excluir</button></form>
                        <?php endif; ?>
                    </td>
                </tr><?php endforeach; ?>
            <?php if (!$products): ?><tr>
                    <td colspan="5">Nenhum produto encontrado.</td>
                </tr><?php endif; ?></tbody>
    </table>
</div>