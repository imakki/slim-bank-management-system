<?php
// Define root path
defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);
defined('ROOT') ?: define('ROOT', dirname(__DIR__) . DS);

// Load .env file
// if (file_exists(ROOT . '.env')) {
//     $dotenv = new Dotenv\Dotenv(ROOT);
//     $dotenv->load();
// }

return [
    'settings' => [
        'displayErrorDetails' => true,
        'logErrors' => true,
        'logErrorDetails' => true,
        'addContentLengthHeader' => false,

    // Renderer settings
    'renderer'               => [
        'template_path' => __DIR__ . '/../templates/',
    ],

    // Monolog settings
    'logger'                 => [
        'name'  => 'Slim bank management',
        'path'  => __DIR__ . '/../logs/app.log',
        'level' => \Monolog\Logger::DEBUG,
    ],

    ]
];