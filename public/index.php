<?php

require '../vendor/autoload.php';

define('ROOT_PATH', dirname(__DIR__) . '/src');
define('APP_PATH', dirname(__DIR__) . '/src');

$router = require '../src/Routes/index.php';