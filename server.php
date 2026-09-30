<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Blade files request assets as /public/... while `php artisan serve` already
// uses the public directory as the web root.
$staticUri = str_starts_with($uri, '/public/') ? substr($uri, 7) : $uri;
$staticFile = __DIR__.'/public'.$staticUri;

if ($staticUri !== '/' && is_file($staticFile)) {
    if ($staticUri === $uri) {
        return false;
    }

    $types = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'json' => 'application/json',
        'map' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'pdf' => 'application/pdf',
    ];
    $extension = strtolower(pathinfo($staticFile, PATHINFO_EXTENSION));
    if (isset($types[$extension])) {
        header('Content-Type: '.$types[$extension]);
    }
    header('Content-Length: '.filesize($staticFile));
    readfile($staticFile);
    return true;
}

require_once __DIR__.'/public/index.php';
