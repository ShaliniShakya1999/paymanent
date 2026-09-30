<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/') {
    $file = null;
    $ext = strtolower(pathinfo($uri, PATHINFO_EXTENSION));

    if ($ext !== 'php' && !str_contains($uri, '/.')) {
        if (str_starts_with($uri, '/public/') && is_file(__DIR__ . $uri)) {
            $file = __DIR__ . $uri;
        } elseif (is_file(__DIR__ . '/public' . $uri)) {
            $file = __DIR__ . '/public' . $uri;
        } elseif (str_starts_with($uri, '/Modules/') && is_file(__DIR__ . $uri)) {
            $file = __DIR__ . $uri;
        }
    }
    if ($file) {
        $mimes = [
            'css'   => 'text/css',
            'js'    => 'application/javascript',
            'png'   => 'image/png',
            'jpg'   => 'image/jpeg',
            'jpeg'  => 'image/jpeg',
            'gif'   => 'image/gif',
            'svg'   => 'image/svg+xml',
            'ico'   => 'image/x-icon',
            'woff'  => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf'   => 'font/ttf',
            'eot'   => 'application/vnd.ms-fontobject',
            'json'  => 'application/json',
            'webp'  => 'image/webp',
        ];
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $contentType = $mimes[$ext] ?? mime_content_type($file);
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, OPTIONS');
        header('Access-Control-Allow-Headers: *');
        header('Content-Type: ' . $contentType);
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

require_once __DIR__.'/public/index.php';
