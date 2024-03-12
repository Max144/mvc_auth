<?php

namespace App\Models;

class User extends Model
{
    protected string $first_name;
    protected string $last_name;
    protected string $email;
    protected string $phone_number;
    protected string $password;

    protected array $validationRules = [
        'first_name' => ['required', 'min:2', 'max:191'],
        'last_name' => ['required', 'min:2', 'max:191'],
        'email' => ['required', 'unique', 'max:191'],
        'phone_number' => ['required', 'max:191'],
        'password' => ['required', 'min:8', 'max:191'],
    ];
    public function set_password($password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}