<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

$root = dirname(__DIR__);

// Validate required variables
$dotenv->required(['DB_FILENAME', 'APP_ENV'])->notEmpty();

$logRelative = $_ENV['LOG_PATH'] ?? 'storage/logs/app.log';

return [
    'db' => [
        'path' => $root . DS . 'database' . DS . $_ENV['DB_FILENAME'],
    ],
    'app' => [
        'env'   => $_ENV['APP_ENV'],
        'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
        'url'   => $_ENV['APP_URL'] ?? '',
    ],
    'log' => [
        'path' => $root . DS . str_replace(['/', '\\'], DS, ltrim((string) $logRelative, '/')),
    ],
    'translate' => [
        'source' => $_ENV['TRANSLATE_SOURCE'] ?? '',
        'target' => $_ENV['TRANSLATE_TARGET'] ?? '',
    ],
];
