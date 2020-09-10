<?php
// Define root path
defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);
defined('ROOT') ?: define('ROOT', dirname(__DIR__) . DS);

// Load .env file
if (file_exists(ROOT . '.env')) {
    $dotenv = new Dotenv\Dotenv(ROOT);
    $dotenv->load();
}

return [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,

        // Database connection settings
      "db" => [
        "host" => "127.0.0.1",
        "dbname" => "bank",
        "user" => "root",
        "pass" => "password",
        "port" => 8889
    ],
    ]
];