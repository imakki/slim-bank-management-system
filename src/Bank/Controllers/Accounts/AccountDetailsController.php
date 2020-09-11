<?php

namespace Bank\Controllers\Accounts;

use Slim\Http\Request;
use Slim\Http\Response;

class AccountDetailsController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function accountDetails(Request $request, Response $response, array $args) {

        $accountId = $request->getAttribute('accountId');

        $sql = "SELECT * FROM accounts where accountId = $accountId";

        $account = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        if(!$account){
            $error = "No user account found!!";
            return $response->withJson($error,404);
        }

        return $response->withJson($account,200);
    }

}