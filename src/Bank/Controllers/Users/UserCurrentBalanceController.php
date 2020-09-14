<?php

namespace Bank\Controllers\Users;

use Slim\Http\Request;
use Slim\Http\Response;

class UserCurrentBalanceController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function getCurrentBalance(Request $request, Response $response, array $args) {

        //echo ("user balance");

        $accountId = $request->getAttribute('accountId');

        $CURRENT_BALANCE_QUERY = "SELECT transaction_number, current_balance FROM accounts where accountId = $accountId ORDER BY transaction_number DESC LIMIT 1";

        $balance = $this->container->db->query($CURRENT_BALANCE_QUERY)->fetchAll(\PDO::FETCH_OBJ);

        return $response->withJson($balance[0],200);

    }

}