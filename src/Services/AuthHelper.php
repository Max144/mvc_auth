<?php

namespace App\Services;

use App\Models\User;

class AuthHelper
{
    private static User $user;

    public static function checkAuth(): bool
    {
        $user = self::getUser();
        return isset($user);
    }

    public static function getUserId(): ?int
    {
        $user = self::getUser();
        return $user?->id;
    }

    public static function getUser(): ?User
    {
        if (!isset(self::$user)) {
            session_start();
            if (!isset($_SESSION['user_id'])) {
                return null;
            }

            self::$user = User::findById($_SESSION['user_id']);
        }

        return self::$user;
    }

    public static function logout(): void
    {
        if (session_status() == PHP_SESSION_DISABLED) {
            session_start();
        }
        unset($_SESSION['user_id']);
    }

    public static function login(User $user): void
    {
        if (session_status() == PHP_SESSION_DISABLED) {
            session_start();
        }
        $_SESSION['user_id'] = $user->id;
    }

    public static function redirectIfNotAuthenticated(): void
    {
        if (!self::checkAuth()) {
            header('Location: /auth/login');
            exit;
        }
    }
}