<?php

use App\Core\Csrf; ?>
<h1 class="h3">Trocar senha</h1>
<form class="card card-body shadow-sm needs-validation" novalidate style="max-width:540px" method="post" action="<?= e(url('password.save')) ?>"><?= Csrf::field() ?>
    <div class="mb-3"><label class="form-label" for="atual">Senha atual</label><input class="form-control" id="atual" name="atual" type="password" required autocomplete="current-password"></div>
    <div class="mb-3"><label class="form-label" for="nova">Nova senha (mínimo 10 caracteres)</label><input class="form-control" id="nova" name="nova" type="password" required minlength="10" autocomplete="new-password"></div>
    <button class="btn btn-primary">Alterar senha</button>
</form>