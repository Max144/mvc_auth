<?php

namespace App;

class Config
{
    private static array $config;

    public static function get(string $key)
    {
        if (empty(self::$config)) {
            self::loadConfig();
        }

        return self::$config[$key] ?? null;
    }

    public static function loadConfig(): void
    {
        self::$config = parse_ini_file('../.env');
    }
}