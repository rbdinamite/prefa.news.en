<?php

namespace App\Repository;

use PDO;

class NewsRepository
{
    public function __construct(private PDO $pdo) {}

    /**
     * SEARCH A LIST OF ACTIVE CITIES FOR NEWS CONSULTATION
     */
    public function getActiveCities(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM city WHERE is_active = 1'
        );
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findAll(int $limit = 20, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM news N INNER JOIN city C ON N.city_id = C.city_id ORDER BY N.news_score DESC LIMIT ? OFFSET ?'
        );
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll();
    }

    public function findBySource(string $source, int $limit = 20): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM news WHERE source_name = ? ORDER BY published_at DESC LIMIT ?'
        );
        $stmt->execute([$source, $limit]);

        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM news WHERE id = ?');
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function findUrlById(int $id): ?string
    {
        $stmt = $this->pdo->prepare('SELECT url_news FROM news WHERE news_id = ? LIMIT 1');
        $stmt->execute([$id]);
        $result = $stmt->fetchColumn();

        return $result ?: null;
    }

    public function checkExists(int $city_id, string $news_title, string $publish_date): bool
    {
        $stmt = $this->pdo->prepare('SELECT 1 FROM news WHERE city_id = ? AND news_title_pt = ? AND date_publish = ? LIMIT 1');
        $stmt->execute([$city_id, $news_title, $publish_date]);

        return (bool) $stmt->fetchColumn();
    }

    public function insert(array $data): void
    {
        $stmt = $this->pdo->prepare('
        INSERT INTO news (city_id, news_title, news_title_pt, date_publish, url_news, url_img, news_description, news_score)
        VALUES (:city_id, :news_title, :news_title_pt, :date_publish, :url_news, :url_img, :news_description, :news_score)
    ');

        $stmt->execute($data);
    }

    public function updateScore(int $city_id, string $news_title, string $publish_date, $news_score): bool
    {
        $stmt = $this->pdo->prepare('UPDATE news SET news_score = ? WHERE city_id = ? AND news_title_pt = ? AND date_publish = ?');
        $stmt->execute([$news_score, $city_id, $news_title, $publish_date]);

        return (bool) $stmt->fetchColumn();
    }

    public function updateLastCheck(int $city_id, string $date_lastcheck, string $date_lastnews): bool
    {
        $stmt = $this->pdo->prepare('UPDATE city SET date_lastcheck = ?, date_lastnews = ? WHERE city_id = ?');
        $stmt->execute([$date_lastcheck, $date_lastnews, $city_id]);

        return (bool) $stmt->fetchColumn();
    }
}
