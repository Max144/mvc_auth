<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Router;

$router = new Router();

$router->get('/', HomeController::class, 'index');

$router->get('/auth/login', AuthController::class, 'showLoginForm');
$router->post('/auth/login', AuthController::class, 'login');
$router->get('/auth/logout', AuthController::class, 'logout');

$router->get('/auth/register', AuthController::class, 'showRegisterForm');
$router->post('/auth/register', AuthController::class, 'register');

$router->dispatch();