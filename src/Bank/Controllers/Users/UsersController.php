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

        $sql = "SELECT * FROM users";

        $users = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        return $response->withJson($users,200);
    }

}