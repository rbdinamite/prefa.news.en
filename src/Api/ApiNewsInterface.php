<?php

namespace App\Api;

interface ApiNewsInterface
{
    public function fetchLatest($city_id, $url_path): array;
}