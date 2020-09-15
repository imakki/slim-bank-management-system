<?php

$container = $app->getContainer();

//error handler
// $container["errorHandler"] = function ($c){
//     return function($request,$response,$exception) use ($c)
//     {
//         return $response->withStatus(500)
//             ->withHeader('Content-Type','application/json')
//             ->write(json_encode(
//                 array(
//                     "success"=>false,
//                     "error"=>"INTERNAL ERROR",
//                     "message"=>"something went wrong internally",
//                     "status_code"=>"500",
//                     'trace'=>$exception->getTraceAsString()
//                 )
//             ));
//     };
// };

//Not found handler
// $container["notFoundHandler"] = function ($c){
//     return function($request,$response,$exception) use ($c)
//     {
//         return $response->withStatus(404)
//             ->withHeader('Content-Type','application/json')
//             ->write(json_encode(
//                 array(
//                     "success"=>false,
//                     "error"=>"NOT FOUND",
//                     "message"=>"Endpoint Not found",
//                     "status_code"=>"404"
//                 )
//             ));
//     };
// };

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

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};