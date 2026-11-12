<?php

use App\Core\Csrf; ?>
<h1 class="h3">Usuários</h1>
<div class="row g-4">
    <div class="col-lg-5">
        <form class="card card-body shadow-sm needs-validation" novalidate method="post" action="<?= e(url('users.save')) ?>">
            <h2 class="h5">Novo usuário</h2><?= Csrf::field() ?>
            <div class="mb-3"><label class="form-label" for="nome">Nome</label><input class="form-control" id="nome" name="nome" maxlength="100" required></div>
            <div class="mb-3"><label class="form-label" for="email">E-mail</label><input class="form-control" id="email" name="email" type="email" maxlength="150" required></div>
            <div class="mb-3"><label class="form-label" for="senha">Senha inicial (mínimo 10 caracteres)</label><input class="form-control" id="senha" name="senha" type="password" minlength="10" required autocomplete="new-password"></div>
            <div class="mb-3"><label class="form-label" for="perfil">Perfil</label><select class="form-select" name="perfil" id="perfil">
                    <option value="operador">Operador</option>
                    <option value="admin">Administrador</option>
                </select></div><button class="btn btn-primary">Criar conta</button>
        </form>
    </div>
    <div class="col-lg-7">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Perfil</th>
                        <th>Ativo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?><tr>
                            <td><?= e($u['nome']) ?></td>
                            <td><?= e($u['email']) ?></td>
                            <td><?= e($u['perfil']) ?></td>
                            <td><?= (int)$u['ativo'] ? 'Sim' : 'Não' ?></td>
                            <td>
                                <?php if ((int)$u['id'] !== (int)\App\Core\Auth::user()['id']): ?><form method="post" action="<?= e(url('users.toggle')) ?>" data-confirm="Alterar o status da conta?"><?= Csrf::field() ?><input type="hidden" name="id" value="<?= (int)$u['id'] ?>"><button class="btn btn-sm btn-outline-secondary"><?= (int)$u['ativo'] ? 'Desativar' : 'Ativar' ?></button></form><?php endif; ?></td>
                        </tr><?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>