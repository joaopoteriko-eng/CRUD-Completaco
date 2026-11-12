<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\User;
use PDOException;

final class UserController
{
    public function index(): void
    {
        Auth::requireAdmin();
        View::render('users/index', ['title' => 'Usuários', 'users' => (new User())->all()]);
    }
    public function save(): void
    {
        Auth::requireAdmin();
        Csrf::verify();
        $name = trim((string)($_POST['nome'] ?? ''));
        $email = strtolower(trim((string)($_POST['email'] ?? '')));
        $password = (string)($_POST['senha'] ?? '');
        $role = (string)($_POST['perfil'] ?? '');
        if ($name === '' || mb_strlen($name) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150 || strlen($password) < 10 || !in_array($role, ['admin', 'operador'], true)) {
            flash('danger', 'Dados do usuário inválidos.');
            go('users');
        }
        try {
            (new User())->create($name, $email, $password, $role);
            flash('success', 'Conta criada.');
        } catch (PDOException $e) {
            flash('danger', 'Não foi possível cadastrar. E-mail talvez duplicado.');
        }
        go('users');
    }
    public function toggle(): void
    {
        $admin = Auth::requireAdmin();
        Csrf::verify();
        $id = positiveId($_POST['id'] ?? null);
        if (!$id || $id === (int)$admin['id']) {
            flash('warning', 'Você não pode desativar sua própria conta.');
            go('users');
        }
        (new User())->toggle($id);
        flash('success', 'Status atualizado.');
        go('users');
    }
}
