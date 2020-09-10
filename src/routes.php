<?php
use Bank\Controllers\Auth\LoginController;
use Bank\Controllers\Auth\RegisterController;
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() {

    // Auth routes
    $this->post('/user', RegisterController::class . ':register')->setName('auth.register');
    $this->post('/user/login', LoginController::class . ':login')->setName('auth.login');

});