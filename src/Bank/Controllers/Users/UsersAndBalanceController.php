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

        //$sql = "SELECT users.accountId, accounts.current_balance, accounts.date_of_transaction, accounts.transaction_number  FROM users RIGHT JOIN accounts ON users.accountId = accounts.accountId ORDER BY accounts.transaction_number";
        $sql = "SELECT DISTINCT accountId,username from users";

        $result = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

        $output = [];
        //loop through distinct id array to fetch current balance of each user
        foreach ($result as $key => $value) {
            $res = $result[$key]->{'accountId'};
            $CURRENT_BALANCE_QUERY = "SELECT current_balance FROM accounts where accountId = $res ORDER BY transaction_number DESC LIMIT 1";

            $balance = $this->container->db->query($CURRENT_BALANCE_QUERY)->fetchAll(\PDO::FETCH_OBJ);
            $value->balance = $balance[0]->{'current_balance'};
            array_push($output, $value);

        }
        
        return $response->withJson($output,200);

    }

}