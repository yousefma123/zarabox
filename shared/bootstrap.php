<?php

    use Dotenv\Dotenv;
    require_once dirname(__DIR__) . '/vendor/autoload.php';

    define('PUBLIC_PATH',  dirname(__DIR__) . '/public');

    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    function public_url(string $path = ''): string {
        return $_ENV['WEB_URL'].'/public' . ($path ? '/' . ltrim($path, '/') : '');
    }
