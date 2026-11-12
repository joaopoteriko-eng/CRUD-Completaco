<?php

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        // O caminho é escolhido apenas pelos controllers, não pelo parâmetro da URL.
        $file = dirname(__DIR__) . '/Views/' . $template . '.php';
        if (!is_file($file)) throw new \RuntimeException('Template ausente: ' . $template);
        extract($data, EXTR_SKIP);
        require dirname(__DIR__) . '/Views/layout/header.php';
        require $file;
        require dirname(__DIR__) . '/Views/layout/footer.php';
    }
}
