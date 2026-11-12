<h1 class="h3">Histórico de movimentações</h1>
<form method="get" class="d-flex gap-2 mb-3"><input type="hidden" name="r" value="movements"><select name="tipo" class="form-select w-auto">
        <option value="">Todas</option>
        <option value="entrada" <?= $type === 'entrada' ? 'selected' : '' ?>>Entradas</option>
        <option value="saida" <?= $type === 'saida' ? 'selected' : '' ?>>Saídas</option>
    </select><button class="btn btn-outline-primary">Filtrar</button></form>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Responsável</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $m): ?><tr>
                    <td><?= e($m['criado_em']) ?></td>
                    <td><?= e($m['produto']) ?></td>
                    <td><?= e($m['tipo']) ?></td>
                    <td><?= (int)$m['quantidade'] ?></td>
                    <td><?= e($m['responsavel']) ?></td>
                    <td><?= e($m['observacao'] ?? '') ?></td>
                </tr><?php endforeach; ?>
            <?php if (!$items): ?><tr>
                    <td colspan="6">Sem registros.</td>
                </tr><?php endif; ?></tbody>
    </table>
</div>