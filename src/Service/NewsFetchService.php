<?php

namespace App\Service;

use App\Api\RssReedIPMNews;
use App\Processor\NewsFetchProcessor;
use App\Repository\NewsRepository;
use App\Logger\Logger;

class NewsFetchService
{
    public function __construct(
        private RssReedIPMNews          $clientIPM,
        private NewsFetchProcessor      $processor,
        private NewsRepository          $repository,
        private Logger                  $logger
    ) {}

    public function run(): void
    {
        // CHECK THE LIST OF ACTIVE CITIES
        $this->logger->info('Getting active cities ...');
        $cities = $this->repository->getActiveCities();

        $this->logger->info('Starting loop for each active city ...');
        foreach ($cities as $city) {
            $this->logger->info('Fetching news from [' . $city['city_name'] . '] - Type [' . $city['url_type'] . '] ...');
            if ($city['url_type'] == 'IPM') {
                $raw = $this->clientIPM->fetchLatest($city['city_id'], $city['url_path']);
            } else {
                $this->logger->error('Unknown URL type!');
                continue;
            }

            if (empty($raw)) {
                $this->logger->warning('No news founded!');
                continue;
            }

            $normalized = $this->processor->normalizeMany($raw);
            
            foreach ($normalized as $item) {
                if (!$this->repository->checkExists($city['city_id'], $item['title_pt'], $item['date'])) {
                    $this->logger->info('Inserting news: [' . $item['title_pt'] . ']');
                    $this->repository->insert([
                        'city_id' => $city['city_id'],
                        'news_title' => $item['title'],
                        'news_title_pt' => $item['title_pt'],
                        'date_publish' => $item['date'],
                        'url_news' => $item['link'],
                        'url_img' => $item['img'],
                        'news_description' => $item['description'],
                        'news_score' => $item['score'],
                        'is_active' => $item['active']
                    ]);
                }
            }
        }

        // AFTER PROCESSING ALL NEWS, UPDATE SCORE OF NEWS
        $this->logger->info('Updating score of news...');
        $news = $this->repository->getAllNews();        
        foreach ($news as $n) {
            $n = $this->processor->calculateScore($n);
            $this->repository->updateScore($n['news_id'], $n['news_title'], $n['news_score']);
        }
        $this->logger->info('Score of news updated!');
        
    }
}
