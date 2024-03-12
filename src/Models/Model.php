<?php

namespace App\Models;

use App\Database\MySqlDatabaseDriver;
use App\Exceptions\ValidationException;
use App\Services\StringHelper;

abstract class Model
{
    protected int $id;
    // by default, the fillable array is null so all properties are fillable
    protected ?array $fillable = null;
    protected string $table;
    protected array $reservedFields = ['id', 'fillable', 'table', 'reservedFields', 'validationRules'];
    protected array $validationRules = [];

    public function __construct()
    {
        $className = explode('\\', get_called_class());
        $this->table = $this->table
            ?? StringHelper::toSnakeCase(end($className)) . 's';
    }

    public function __get(string $name)
    {
        $accessorMethodName = 'get_' . $name;
        // Allow models to transform the property value when it is accessed
        if (method_exists($this, $accessorMethodName)) {
            return $this->$accessorMethodName();
        }

        // Otherwise, return the property value
        return $this->$name ?? null;
    }

    public function __set(string $name, $value)
    {
        $setter = 'set_' . $name;
        // Allow models to transform the property value when it is set
        if (method_exists($this, $setter)) {
            $this->$setter($name, $value);
        } else {
            $this->$name = $value;
        }
    }

    public static function create(array $data): static
    {
        // Create a new record in the database
        $entity = new static();
        foreach ($data as $key => $value) {
            $setter = 'set_' . $key;
            if (method_exists($entity, $setter)) {
                $entity->$setter($value);
            } else {
                $entity->$key = $value;
            }
        }

        return $entity->save();
    }

    public function save(): static
    {
        $validationErrors = $this->validate();
        if (count($validationErrors) > 0) {
            throw new ValidationException($validationErrors);
        }
        if (isset($this->fillable)) {
            $fields = $this->fillable;
        } else {
            $properties = get_class_vars(static::class);
            $fields = array_diff(array_keys($properties), $this->reservedFields);
        }

        $values = [];
        $placeholders = [];

        foreach ($fields as $field) {
            $values[] = $this->$field ?? null;
            $placeholders[] = '?';
        }
        $driver = MySqlDatabaseDriver::getInstance();

        $sql = 'INSERT INTO ' . $this->table
            . ' (' . implode(', ', $fields) . ')'
            . ' VALUES (' . implode(', ', $placeholders) . ')';

        $statement = $driver->getConnection()
            ->prepare($sql);
        $statement->execute($values);

        $this->id = $driver->getConnection()->insert_id;
        return $this;
    }

    public static function findById(int $id): ?static
    {
        return self::find('id', $id);
    }

    public static function find(string $fieldName, mixed $value): ?static
    {
        $driver = MySqlDatabaseDriver::getInstance();
        $entity = new static();
        $tableName = $entity->table;
        $statement = $driver->getConnection()->prepare("SELECT * FROM {$tableName} WHERE {$fieldName} = ?");
        $statement->bind_param('s', $value);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        foreach ($result->fetch_array(MYSQLI_ASSOC) as $key => $value) {
            $entity->$key = $value;
        }

        return $entity;
    }

    protected function validate(): array
    {
        $errors = [];

        foreach ($this->validationRules as $field => $rules) {
            foreach ($rules as $rule) {
                if ($rule === 'required' && empty($this->$field)) {
                    $errors[] = [
                        'field' => $field,
                        'message' => 'The ' . $field . ' field is required'
                    ];
                }
                if ($rule === 'unique') {
                    $entity = self::find($field, $this->$field);
                    if (isset($entity) && (!isset($this->id) || $entity->id !== $this->id)){
                        $errors[] = [
                            'field' => $field,
                            'message' => 'The ' . $field . ' field must be unique'
                        ];
                    }
                }
                if (str_contains($rule, 'min:')) {
                    $min = explode(':', $rule)[1];
                    if (strlen($this->$field) < $min) {
                        $errors[] = [
                            'field' => $field,
                            'message' => 'The ' . $field . ' field must be at least ' . $min . ' characters'
                        ];
                    }
                }
                if (str_contains($rule, 'max:')) {
                    $max = explode(':', $rule)[1];
                    if (strlen($this->$field) > $max) {
                        $errors[] = [
                            'field' => $field,
                            'message' => 'The ' . $field . ' field must be at most ' . $max . ' characters'
                        ];
                    }
                }
            }
        }

        return $errors;
    }
}