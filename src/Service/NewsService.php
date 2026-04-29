<?php

namespace App\Service;

use App\Repository\NewsRepository;

class NewsService
{
    public function __construct(private NewsRepository $repository) {}

    /**
     * Returns the most recent news item to be used as the hero.
     */
    public function getHero(): array
    {
        return $this->repository->findAll(limit: 1, offset: 0)[0] ?? [];
    }

    /**
     * Returns news items for the sidebar, skipping the hero.
     */
    public function getSidebar(int $limit = 5): array
    {
        return $this->repository->findAll(limit: $limit, offset: 1);
    }

    /**
     * Returns news items for the initial latest news grid.
     */
    public function getLatest(int $limit = 8): array
    {
        return $this->repository->findAll(limit: $limit, offset: 6);
    }

    /**
     * Returns a paginated batch of news for infinite scroll.
     * Offset accounts for all items already rendered on initial load:
     * 1 hero + 5 sidebar + 8 latest = 14 items.
     */
    public function getPage(int $page, int $limit = 12): array
    {
        $offset = ($page * $limit) + 14;

        return $this->repository->findAll(limit: $limit, offset: $offset);
    }
}