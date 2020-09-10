<?php

$container = $app->getContainer();

// PDO database library 
$container['db'] = function ($c) {

    $host = "127.0.0.1";
    $user="root";
    $password="root";
    $db="bank";
    $port=8889;

    $settings = $c->get('settings')['db'];
    $pdo = new PDO("mysql:host=$host;dbname=$db;port=$port;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
