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

//View Routes

$app->get('/',
    function (Request $request, Response $response, array $args) {
        // Render index view
        return $this->renderer->render($response, 'index.html');
});

$app->get('/dashboard/{accountId}',
    function (Request $request, Response $response, array $args) {
        $accountId = $request->getAttribute('accountId');

        $sql = "SELECT * FROM `users` WHERE `accountId` = '$accountId'";
        $user = $this->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        //check if admin
        $admin = $user[0]->{'isBanker'};

        if($admin){
            return $this->renderer->render($response, 'banker.html', $args);
        }else{
            return $this->renderer->render($response, 'customer.html', $args);
        }
       
});