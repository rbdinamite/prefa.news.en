<?php

namespace App\Api;

use SimplePie\SimplePie;
use App\Logger\Logger;

class RssReedIPMNews implements ApiNewsInterface
{
    public function __construct(
        private Logger $logger
    ) {}

    public function fetchLatest($url_path): array
    {
        // INICIALIZES THE LIBRARY  RESPONSIBLE FOR THE QUERY
        $feed = new SimplePie();
        $feed->set_feed_url($url_path);
        $feed->set_cache_location(__DIR__ . '/../../storage/cache');
        $feed->init();
        $feed->handle_content_type();

        $xml = new \DOMDocument();
        $check_latest_date = True;
        $items = [];
        foreach ($feed->get_items(0, 5) as $item) {
            // CHECK THE LATEST NEWS DATE
            if ($check_latest_date) {
                $news_date = new \Datetime($item->get_date('Y-m-d'));
                $interval = $news_date->diff(new \Datetime("now"));
                //news_log('Data noticia mais recente: [' . $item->get_date('Y-m-d') . '] [' . $interval->format('%R%a dias') . ']');
                if ($interval->format('%a') > 15) {
                    $this->logger->warning('No recent news (15 days) found. Ignoring city...');
                    break;
                }
                //updateCheckDate($sqlite, $city->id, $item->get_date('Y-m-d'));
                $check_latest_date = False;
            }

            $this->logger->info('New article: [' . $item->get_date('Y-m-d') . '] [' . $item->get_title() .']');
            $items[] = [
                'title' => $item->get_title(),
                'date' => $item->get_date('Y-m-d H:i:s'),
                'link' => $item->get_permalink(),
                'img' => $this->extractCoverImage($item->get_permalink()),
                'description' => $item->get_description()
            ];
        }

        return $items;
    }

    /**
     * PERFORMS VALIDATION OF THE QUERIED URL

    private function valideUrl(string $url): bool
    {
        $path = parse_url($url, PHP_URL_PATH);
        $encoded_path = array_map('urlencode', explode('/', $path));
        $url = str_replace($path, implode('/', $encoded_path), $url);

        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }
             */

    private function extractCoverImage(string $pageUrl): ?string
    {
        $html = file_get_contents($pageUrl);

        if ($html === false) {
            $this->logger->warning('Could not fetch page content: ' . $pageUrl);
            return null;
        }

        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($html);
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        $xpath    = new \DOMXPath($dom);
        $ogImage  = $xpath->query('//meta[@property="og:image"]');

        if ($ogImage->length > 0) {
            return $ogImage->item(0)->getAttribute('content');
        }

        // Fallback: primeira imagem do conteúdo
        $images = $xpath->query('//article//img | //main//img');

        if ($images->length > 0) {
            return $images->item(0)->getAttribute('src');
        }

        $this->logger->warning('No cover image found for: ' . $pageUrl);
        return null;
    }
}
