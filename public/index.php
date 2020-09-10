<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__. '/../src/config/db.php';

$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// require '../src/routes/customer.php';
// require '../src/routes/users.php';
require __DIR__ . '/../src/routes.php';
require __DIR__ . '/../src/dependencies.php';


$app->run();