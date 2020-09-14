<?php

namespace Bank\Controllers\Users;

use Slim\Http\Request;
use Slim\Http\Response;

class UsersAndBalanceController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function getAllUsersBalance(Request $request, Response $response, array $args) {

        //echo ("users balance");

        $sql = "SELECT DISTINCT accountId  FROM accounts";

        $result = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        return $response->withJson($result,200);

    }

}