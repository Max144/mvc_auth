<?php

namespace App\Exceptions;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation failed, errors: ' . json_encode($errors));
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}