<?php

// Definir constantes básicas
define('APP_ROOT', __DIR__);
define('CONFIG_PATH', APP_ROOT . '/config');
define('PLUGIN_PATH', APP_ROOT . '/plugins');
define('LOG_PATH', '/var/www/logs');

// Carregar o autoloader do Composer
require_once APP_ROOT . '/vendor/autoload.php';

// Carregar configurações
$config = require CONFIG_PATH . '/config.php';

// Inicializar o gerenciador de plugins
$pluginManager = \Core\Plugin\PluginManager::getInstance();
$pluginManager->loadPlugins();

// Inicializar o logger
$logger = \Core\Log\Logger::getInstance();

// Configurar tratamento de erros
set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($logger) {
    $logger->error("PHP Error: [$errno] $errstr", [
        'file' => $errfile,
        'line' => $errline
    ]);
});

set_exception_handler(function ($exception) use ($logger) {
    $logger->critical("Uncaught Exception: " . $exception->getMessage(), [
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTraceAsString()
    ]);
});

// Configurar fuso horário
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão
session_start();

// Configurar headers de segurança
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('X-XSS-Protection: 1; mode=block');
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
} 