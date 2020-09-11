<?php

namespace Bank\Controllers\Users;

use Slim\Http\Request;
use Slim\Http\Response;

class UsersController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function getAllUsers(Request $request, Response $response, array $args) {
        echo json_encode("all users");
    }

}