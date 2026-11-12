<h1 class="h3">Dashboard</h1>
<p class="text-secondary">Indicadores calculados diretamente no MySQL pelo Model.</p>
<div class="row g-3 mb-4">
    <?php foreach ([['Produtos', $stats['total_produtos']], ['Unidades', $stats['unidades']], ['Valor', 'R$ ' . number_format((float)$stats['valor'], 2, ',', '.')], ['Estoque baixo (≤5)', $stats['baixos']]] as $card): ?>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-secondary small"><?= e((string)$card[0]) ?></p><strong class="h3"><?= e((string)$card[1]) ?></strong>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<h2 class="h5">Movimentações recentes</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Responsável</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recent as $m): ?><tr>
                    <td><?= e($m['produto']) ?></td>
                    <td><?= e($m['tipo']) ?></td>
                    <td><?= (int)$m['quantidade'] ?></td>
                    <td><?= e($m['responsavel']) ?></td>
                    <td><?= e($m['criado_em']) ?></td>
                </tr><?php endforeach; ?>
            <?php if (!$recent): ?><tr>
                    <td colspan="5">Sem movimentações.</td>
                </tr><?php endif; ?></tbody>
    </table>
</div>