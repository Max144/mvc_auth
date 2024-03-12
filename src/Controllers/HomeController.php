<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthHelper;

class HomeController extends Controller
{
    public function index()
    {
        AuthHelper::redirectIfNotAuthenticated();
        $userId = AuthHelper::getUserId();
        $user = User::findById($userId);
        $this->render('home', ['user' => $user]);
    }
}