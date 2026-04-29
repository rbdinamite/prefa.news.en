<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\NewsRepository;
use App\Service\NewsService;

header('Content-Type: application/json');

$config     = require __DIR__ . '/../../config/config.php';
$pdo        = Connection::getInstance($config);
$repository = new NewsRepository($pdo);
$service    = new NewsService($repository);

$page  = max(0, (int) ($_GET['page'] ?? 0));
$limit = 12;

$news = $service->getPage($page, $limit);

echo json_encode(['data' => $news, 'page' => $page]);