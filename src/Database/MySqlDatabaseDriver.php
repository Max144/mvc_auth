<?php

namespace App\Database;

use App\Config;
use mysqli;
use mysqli_result;
use \Exception;

class MySqlDatabaseDriver
{
    private static ?self $instance;

    private string $host;
    private string $username;
    private string $password;
    private string $database;
    private mysqli $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->host = Config::get('MYSQL_HOST');
        $this->username = Config::get('MYSQL_USERNAME');
        $this->password = Config::get('MYSQL_PASSWORD');
        $this->database = Config::get('MYSQL_DATABASE');

        if (!isset($this->host, $this->username, $this->password, $this->database)) {
            throw new Exception('Database configuration not set');
        }
        $this->initConnection();
    }

    /**
     * @throws Exception
     */
    function __destruct() {
        self::$instance = null;
        $this->closeConnection();
    }

    public static function getInstance(): MySqlDatabaseDriver
    {
        return self::$instance ?? new self();
    }

    /**
     * @throws Exception
     */
    public function getConnection(): mysqli
    {

        return $this->connection;
    }

    /**
     * @throws Exception
     */
    private function initConnection(): void
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            throw new Exception("Connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * @throws Exception
     */
    public function closeConnection(): void
    {
        if (!isset($this->connection)) {
            throw new Exception('no connection initiated');
        }
        $this->connection->close();
    }

    public function query(string $query): mysqli_result|bool
    {
        $result = $this->connection->query($query);

        if (!$result) {
            throw new Exception("Query failed: " . $this->connection->error);
        }

        return $result;
    }
}