<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\NewsRepository;
use App\Service\NewsService;

$config     = require __DIR__ . '/../config/config.php';
$pdo        = Connection::getInstance($config);
$repository = new NewsRepository($pdo);
$service    = new NewsService($repository);

$activeCityCount = $service->getActiveCityCount();
$currentPage     = 'about';

require __DIR__ . '/../templates/about.php';
