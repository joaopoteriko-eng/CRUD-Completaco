<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\View;
use App\Models\Product;
use App\Models\Movement;

final class DashboardController
{
    public function index(): void
    {
        Auth::requireLogin();
        View::render('dashboard/index', [
            'title' => 'Dashboard',
            'stats' => (new Product())->stats(),
            'recent' => (new Movement())->recent(6)
        ]);
    }
}
