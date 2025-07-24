<?php

    use Dotenv\Dotenv;
    require_once __DIR__ . '/vendor/autoload.php';

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();


    function public_url(string $path = ''): string {
        return $_ENV['WEB_URL'].'/public' . ($path ? '/' . ltrim($path, '/') : '');
    }
    