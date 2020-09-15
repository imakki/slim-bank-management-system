<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \slim\App;

function jsonResponse($data, $code = 200)
{
    // $app->response->setStatus($code);
    // $app->response->headers->set(
    //     'Content-type',
    //     'application/json; charset=utf-8'
    // );
    return json_encode($data);
}

$app->get('/home', function (Request $request, Response $reponse) {
    echo 'homepage';
});

//get all users
$app->get('/users', function(Request $request, Response $reponse) {
    $sql = "SELECT * FROM  users";

    try {
        $db = new db();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $pdo = null;
        echo json_encode($users);

    } catch (\PDOException $e) {
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }
});

//user registraion
$app->post('/user/register', function(Request $request, Response $reponse, array $args){
    $username = $request->getParam('username');
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    try {
        $db = new db();
        $pdo = $db->connect();

        $sql = "INSERT INTO users (username,email,password) VALUES (?,?,?)";
        $pdo->prepare($sql)->execute([$username,$email,$password]);
        echo '{"notice": {"text": "user '. $username .' has been just added now"}}';
        $pdo = null;

    } catch (\PDOException $e) {
        //throw $th;
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
    }
});

//user login
$app->post('/user/login', function(Request $request, Response $reponse, array $args){
    $email = $request->getParam('email');
    $password = $request->getParam('password');

    if(empty($email) || empty($password)){
        $error = 'Email and Password are required';
        // Bad request
        return jsonResponse($error, 400);
    }
    $row = array();
    try {
        $db = new db();
        $pdo = $db->connect();
        
        $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
        
        $result = $pdo->query($sql);

        if (!$result) {
            $error = 'Invalid query: ' . mysql_error();
            // Internal server error
            return jsonResponse($error, 500);
        }
        $user = $result->fetch(PDO::FETCH_OBJ);
        if (empty($user)) {
            // Unauthorized
            return jsonResponse($error, 401);
        }
        $row["user"] = $user;
        $pdo = null;

    } catch (\PDOException $e) {
        //throw $th;
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
        // Internal server error
        return jsonResponse($error, 500);
    }
    // OK, default is 200
    return jsonResponse($row);

});

$app->run();
