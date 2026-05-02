<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;
use App\Repository\NewsRepository;
use App\Service\NewsFetchService;
use App\Api\RssReedIPMNews;
use App\Processor\NewsFetchProcessor;
use App\Logger\Logger;

$config     = require __DIR__ . '/../config/config.php';
$logger     = new Logger($config['log']['path'] . DS . date('Ymd') . DS . 'fetch-news.log');
$pdo        = Connection::getInstance($config);
$repository = new NewsRepository($pdo);
$clientIPM  = new RssReedIPMNews($logger, $repository);
$processor  = new NewsFetchProcessor($config, $logger);
$service    = new NewsFetchService($clientIPM, $processor, $repository, $logger);

$service->run();