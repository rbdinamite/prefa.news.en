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
                $raw = $this->clientIPM->fetchLatest($city['url_path']);
            } else {
                $this->logger->error('Unknown URL type!');
                continue;
            }

            if (empty($raw)) {
                $this->logger->warning('No news founded!');
                continue;
            }

            $normalized = $this->processor->normalizeMany($raw); // @todo: O processor vai traduzir as notícias para ingles.
            
            foreach ($normalized as $item) {                
                if (!$this->repository->checkExists($city['city_id'], $item['title_pt'], $item['date'])) {
                    $this->repository->insert([
                        'city_id' => $city['city_id'],
                        'news_title' => $item['title'],
                        'news_title_pt' => $item['title_pt'],
                        'date_publish' => $item['date'],
                        'url_news' => $item['link'],
                        'url_img' => $item['img'],
                        'news_description' => $item['description'],
                        'news_score' => $item['score']
                    ]);
                } else {
                    $this->repository->updateScore($city['city_id'], $item['title_pt'], $item['date'], $item['score']);
                }
            }
        }
    }    
}
