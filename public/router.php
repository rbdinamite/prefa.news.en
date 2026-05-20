<?php

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($path === '/about' || $path === '/about/') {
    require __DIR__ . '/about.php';
    return true;
}

return false;
