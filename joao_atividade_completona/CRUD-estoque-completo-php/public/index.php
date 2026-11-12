<?php

declare(strict_types=1);
// FRONT CONTROLLER: todas as requisições HTTP passam por este arquivo.
require dirname(__DIR__) . '/app/bootstrap.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\ProductController;
use App\Controllers\MovementController;
use App\Controllers\UserController;

// Roteador explícito evita executar métodos arbitrários a partir da URL.
$routes = [
    'login' => ['GET', AuthController::class, 'form'],
    'login.submit' => ['POST', AuthController::class, 'login'],
    'logout' => ['POST', AuthController::class, 'logout'],
    'password' => ['GET', AuthController::class, 'passwordForm'],
    'password.save' => ['POST', AuthController::class, 'changePassword'],
    'dashboard' => ['GET', DashboardController::class, 'index'],
    'products' => ['GET', ProductController::class, 'index'],
    'products.create' => ['GET', ProductController::class, 'form'],
    'products.edit' => ['GET', ProductController::class, 'form'],
    'products.save' => ['POST', ProductController::class, 'save'],
    'products.delete' => ['POST', ProductController::class, 'delete'],
    'movements' => ['GET', MovementController::class, 'index'],
    'movements.create' => ['GET', MovementController::class, 'form'],
    'movements.save' => ['POST', MovementController::class, 'save'],
    'users' => ['GET', UserController::class, 'index'],
    'users.save' => ['POST', UserController::class, 'save'],
    'users.toggle' => ['POST', UserController::class, 'toggle'],
];
$route = (string)($_GET['r'] ?? 'dashboard');
if (!isset($routes[$route])) {
    http_response_code(404);
    exit('Página não encontrada.');
}
[$method, $controller, $action] = $routes[$route];
if ($_SERVER['REQUEST_METHOD'] !== $method) {
    header('Allow: ' . $method);
    http_response_code(405);
    exit('Método não permitido.');
}
try {
    (new $controller())->$action();
} catch (Throwable $e) {
    error_log((string)$e);
    http_response_code(500);
    exit('Falha interna. Consulte o registro de erros do PHP.');
}
