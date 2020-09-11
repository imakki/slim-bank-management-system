<?php

namespace Bank\Controllers\Users;

use Slim\Http\Request;
use Slim\Http\Response;

class UserController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function getUserById(Request $request, Response $response, array $args) {

        echo json_encode("user by id");

    }

}