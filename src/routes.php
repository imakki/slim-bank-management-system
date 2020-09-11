<?php
use Bank\Controllers\Auth\LoginController;
use Bank\Controllers\Auth\RegisterController;
use Bank\Controllers\Accounts\AccountDetailsController;
use Bank\Controllers\Accounts\AccountTransactionController;
use Bank\Controllers\Users\UsersController;
use Bank\Controllers\Users\UserController;
use Slim\Http\Request;
use Slim\Http\Response;

$app->group('/api', function() {

    // Auth routes
    $this->post('/user/register', RegisterController::class . ':register')->setName('auth.register');
    $this->post('/user/login', LoginController::class . ':login')->setName('auth.login');

    //User routes
    $this->get('/users', UsersController::class . ':getAllUsers')->setName('auth.getAllUsers');
    $this->get('/user/{accountId}', UserController::class . ':getUserById')->setName('auth.getUserById');

    //account routes
    $this->get('/account/{accountId}', AccountDetailsController::class . ':accountDetails')->setName('auth.accountDetails');
    $this->post('/account/transaction/{accountId}', AccountTransactionController::class . ':transactions')->setName('auth.transactions');
});