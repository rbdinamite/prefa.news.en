<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\NewsRepository;

header('Content-Type: application/json');

// JUST POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// BODY VALIDATION
$body = json_decode(file_get_contents('php://input'), true);
$id   = isset($body['id']) ? (int) $body['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid ID']);
    exit;
}

$config     = require __DIR__ . '/../../config/config.php';
$pdo        = Connection::getInstance($config);
$repository = new NewsRepository($pdo);
$url        = $repository->findUrlById($id);

if ($url === null) {
    http_response_code(404);
    echo json_encode(['error' => 'News not found']);
    exit;
}

echo json_encode(['url' => $url]);