<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Models\User;
use App\Services\AuthHelper;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $this->middleware('guest');
        $this->render('login-form');
    }

    public function login()
    {
        $this->middleware('guest');
        $user = User::find('email', $_POST['email']);

        if (!$user) {
            header('Location: /auth/login');
            exit;
        }

        if (!password_verify($_POST['password'], $user->password)) {
            header('Location: /auth/login');
            exit;
        }

        AuthHelper::login($user);

        header('Location: /');
    }

    public function showRegisterForm()
    {
        $this->middleware('guest');
        $this->render('register-form');
    }

    public function register()
    {
        $this->middleware('guest');
        try {
            $user = User::create($_POST);
        } catch (ValidationException $e) {
            // log error, return errors to the form...
            header('Location: /auth/register');
            exit;
        }

        AuthHelper::login($user);

        header('Location: /');
    }

    public function logout()
    {
        $this->middleware('auth');
        AuthHelper::logout();

        header('Location: /');
    }
}