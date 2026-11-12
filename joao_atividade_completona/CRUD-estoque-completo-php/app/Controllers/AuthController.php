<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\View;
use App\Models\User;

final class AuthController
{
    public function form(): void
    {
        if (Auth::user()) go('dashboard');
        View::render('auth/login', ['title' => 'Entrar', 'guest' => true]);
    }
    public function login(): void
    {
        Csrf::verify();
        $email = strtolower(trim((string)($_POST['email'] ?? '')));
        $senha = (string)($_POST['senha'] ?? '');
        $u = filter_var($email, FILTER_VALIDATE_EMAIL) ? (new User())->byEmail($email) : null;
        if (!$u || !(int)$u['ativo'] || !password_verify($senha, $u['senha_hash'])) {
            flash('danger', 'E-mail ou senha incorretos.');
            go('login');
        }
        Auth::login((int)$u['id']);
        flash('success', 'Bem-vindo(a)!');
        go('dashboard');
    }
    public function logout(): void
    {
        Auth::requireLogin();
        Csrf::verify();
        Auth::logout();
        go('login');
    }
    public function passwordForm(): void
    {
        Auth::requireLogin();
        View::render('auth/password', ['title' => 'Minha senha']);
    }
    public function changePassword(): void
    {
        $u = Auth::requireLogin();
        Csrf::verify();
        $atual = (string)($_POST['atual'] ?? '');
        $nova = (string)($_POST['nova'] ?? '');
        if (!password_verify($atual, $u['senha_hash']) || strlen($nova) < 10) {
            flash('danger', 'Senha atual incorreta ou nova senha com menos de 10 caracteres.');
            go('password');
        }
        (new User())->changePassword((int)$u['id'], $nova);
        flash('success', 'Senha alterada.');
        go('password');
    }
}
