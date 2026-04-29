<?php

namespace App\Api;

interface ApiNewsInterface
{
    public function fetchLatest($url_path): array;
}