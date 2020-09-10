<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $reponse) {
    echo 'home user working';
});

//get all customers
$app->get('/api/customers', function (Request $request, Response $reponse) {
    $sql = "SELECT * FROM  customers";

    try {
        $db = new db();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $customers = $stmt->fetchAll(PDO::FETCH_OBJ);

        $pdo = null;
        echo json_encode($customers);

    } catch (\PDOException $e) {
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }
});

//get customer by id
$app->get('/api/customers/{id}', function (Request $request, Response $reponse, array $args) {
    $id = $request->getAttribute('id');

    $sql = "SELECT * FROM customers where id = $id";

    try{
        $db = new db();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $customer = $stmt->fetchAll(PDO::FETCH_OBJ);

        $pdo = null;
        echo json_encode($customer);
    } catch(\PDOException $e) {
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }

});


//add a customer
$app->post('/api/customers/add', function (Request $request, Response $reponse, array $args){
    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');

    try {
        $db = new db();
        $pdo = $db->connect();

        $sql = "INSERT INTO customers (first_name,last_name) VALUES (?,?)";

        $pdo->prepare($sql)->execute([$first_name,$last_name]);

        echo '{"notice": {"text": "customer '. $first_name .' has been just added now"}}';

        $pdo = null;

    } catch (\Throwable $th) {
        //throw $th;
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }

});

//update customer info
$app->post('/api/customers/update/{id}', function(Request $request, Response $reponse, array $args){
    $id = $request->getAttribute('id');

    $first_name = $request->getParam('first_name');
    $last_name = $request->getParam('last_name');
    
    try {
        $db = new db();
        $pdo = $db->connect();

        $sql = "UPDATE customers SET first_name=?, last_name=? where id=?";

        $pdo->prepare($sql)->execute([$first_name,$last_name,$id]);

        echo '{"notice": {"text": "customer '. $first_name .' has been just updated now"}}';
        $pdo = null;

    } catch (\Throwable $th) {
        //throw $th;
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }
});

//delete a customer
$app->delete('/api/customers/delete/{id}', function(Request $request, Response $reponse, array $args){
    $id = $request->getAttribute('id');

    try {
        $db = new db();
        $pdo = $db->connect();

        $sql = "DELETE FROM customers where id=?";

        $pdo->prepare($sql)->execute([$id]);
        echo '{"notice": {"text": "customer with id:'. $id .' has been deleted"}}';
        $pdo = null;

    } catch (\Throwable $th) {
        //throw $th;
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }

});

