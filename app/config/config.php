<?php

return [
    'database' => [
        'host' => getenv('DB_HOST') ?: 'mysql',
        'dbname' => getenv('DB_DATABASE') ?: 'ecommerce',
        'username' => getenv('DB_USERNAME') ?: 'user',
        'password' => getenv('DB_PASSWORD') ?: 'password',
    ],
    'redis' => [
        'host' => getenv('REDIS_HOST') ?: 'redis',
        'port' => 6379,
    ],
    'app' => [
        'name' => 'E-commerce SaaS',
        'url' => getenv('APP_URL') ?: 'http://localhost',
        'debug' => getenv('APP_DEBUG') ?: true,
    ],
    'stripe' => [
        'public_key' => getenv('STRIPE_PUBLIC_KEY'),
        'secret_key' => getenv('STRIPE_SECRET_KEY'),
    ],
    'plugins' => [
        'directory' => __DIR__ . '/../plugins',
        'enabled' => true,
    ],
    'logs' => [
        'directory' => '/var/www/logs',
        'level' => 'debug',
    ],
]; 