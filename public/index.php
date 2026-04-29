<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\NewsRepository;
use App\Service\NewsService;

$config     = require __DIR__ . '/../config/config.php';
$pdo        = Connection::getInstance($config);
$repository = new NewsRepository($pdo);
$service    = new NewsService($repository);

$heroNews    = $service->getHero();
$sidebarNews = $service->getSidebar(5);
$latestNews  = $service->getLatest(8);

// $heroNews, $sidebarNews, $latestNews e $wideNews

require __DIR__ . '/../templates/layout.php';