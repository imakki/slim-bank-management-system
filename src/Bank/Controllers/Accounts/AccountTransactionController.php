<?php

namespace Bank\Controllers\Accounts;

use Slim\Http\Request;
use Slim\Http\Response;

class AccountTransactionController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function transactions(Request $request, Response $response, array $args) {

        $accountId = $request->getAttribute('accountId');

        $transactionMode = $request->getParam('medium_of_transaction');
        $transactionType = $request->getParam('transaction_type');
        $transactionAmount = $request->getParam('transaction_amount');

        //echo ($transactionType);

        $CURRENT_BALANCE_QUERY = "SELECT transaction_number, current_balance FROM accounts where accountId = $accountId ORDER BY transaction_number DESC LIMIT 1";

        $balance = $this->container->db->query($CURRENT_BALANCE_QUERY)->fetchAll(\PDO::FETCH_OBJ);

        if(!$balance){
            echo "no balance";
            $current_balance = $transactionAmount;
            $if_not_balance = "INSERT INTO accounts (accountId,current_balance,medium_of_transaction,transaction_type,transaction_amount) VALUES (?,?,?,?,?)";
            $transaction_if_no_balance = $this->container->db->prepare($if_not_balance)->execute([$accountId,$current_balance,$transactionMode,$transactionType,$transactionAmount]);
            return $response->withJson($transaction_if_no_balance,200);
        }else if($balance){

            $c_balance = $balance[0]->{'current_balance'};
            
            if($transactionType === "credit"){
                echo "credit";
                $current_balance = $transactionAmount + $c_balance;
                $If_balance = "INSERT INTO accounts (accountId,current_balance,medium_of_transaction,transaction_type,transaction_amount) VALUES (?,?,?,?,?)";
                $transaction_if_balance = $this->container->db->prepare($If_balance)->execute([$accountId,$current_balance,$transactionMode,$transactionType,$transactionAmount]);
                return $response->withJson($transaction_if_balance,200);
           }else if($transactionType === "debit"){
               //echo "debit";
               if($transactionAmount > $c_balance){
                   echo json_encode("withdrawal amount exceeds current amount!!");
               }else{
                    $current_balance = $c_balance - $transactionAmount;
                    $query_debit = "INSERT INTO accounts (accountId,current_balance,medium_of_transaction,transaction_type,transaction_amount) VALUES (?,?,?,?,?)";
                    $debit_transaction = $this->container->db->prepare($query_debit)->execute([$accountId,$current_balance,$transactionMode,$transactionType,$transactionAmount]);
                    return $response->withJson($debit_transaction,200);
               }
           }
        }

    }

}