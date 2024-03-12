<?php

namespace App\Controllers;

use App\Services\AuthHelper;

class Controller
{
    protected function render($view, $data = []): void
    {
        extract($data);

        include APP_PATH . "/Views/{$view}.php";
    }

    protected function middleware($middleware, $options = [])
    {
        if ($middleware === 'guest') {
            if (AuthHelper::checkAuth()) {
                header('Location: /');
                exit;
            }
        }

        if ($middleware === 'auth') {
            if (!AuthHelper::checkAuth()) {
                header('Location: /auth/login');
                exit;
            }
        }
    }
}