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

        $accountId = $request->getAttribute('accountId');

        $sql = "SELECT * FROM users where accountId = $accountId";

        $user = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        if(!$user){
            $error = "No user account found!!";
            return $response->withJson($error,404);
        }

        return $response->withJson($user,200);

    }

}