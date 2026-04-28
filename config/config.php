<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// Validate required variables
$dotenv->required(['DB_FILENAME', 'APP_ENV'])->notEmpty();
return [
    'db' => [
        'path' => __DIR__ . DS . '..' . DS . 'database' . DS . $_ENV['DB_FILENAME'],
    ],
    'app' => [
        'env'   => $_ENV['APP_ENV'],
        'debug' => $_ENV['APP_DEBUG'] === 'true',
        'url'   => $_ENV['APP_URL'],
    ],
    'log' => [
        'path' => __DIR__ . '/' . $_ENV['LOG_PATH'],
    ],
    'translate' => [
        'source' => $_ENV['TRANSLATE_SOURCE'],
        'target' => $_ENV['TRANSLATE_TARGET'],
    ],
];
