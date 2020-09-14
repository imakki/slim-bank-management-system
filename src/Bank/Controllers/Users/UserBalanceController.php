<?php

namespace Bank\Controllers\Users;

use Slim\Http\Request;
use Slim\Http\Response;

class UserBalanceController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function getUserBalance(Request $request, Response $response, array $args) {

        //echo ("user balance");

        $accountId = $request->getAttribute('accountId');

        $sql = "SELECT accountId,date_of_transaction,current_balance,transaction_type,transaction_amount,transaction_number FROM accounts where accountId = $accountId";

        $result = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        if(!$result){
            $error = "No balance found";
            return $response->withJson($error,200);
        }

        return $response->withJson($result,200);

    }

}