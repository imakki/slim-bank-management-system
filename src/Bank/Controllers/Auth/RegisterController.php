<?php

namespace Bank\Controllers\Auth;

use DateTime;
use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

function generateToken() {
    $now = new DateTime();
    $future = new DateTime("now +2 hours");

    $payload = [
        "iat" => $now->getTimeStamp(),
        "exp" => $future->getTimeStamp(),
        "jti" => base64_encode(random_bytes(16)),
    ];

    $secret = "supersecretkeyyoushouldnotcommittogithub";

    $token = JWT::encode($payload, $secret, "HS256");

    return $token;
}

class RegisterController {

    private $container;
    
    public function __construct ($container) {
        $this->container = $container;        
    }

    public function register(Request $request, Response $response) {

        $username = $request->getParam('username');
        $email = $request->getParam('email');
        $password = $request->getParam('password');
        $token = generateToken();

        try {
            $users = $this->container->db->query("SELECT * FROM `users` WHERE `email` = '$email'")->fetchAll(\PDO::FETCH_OBJ);
            if($users){
                $error = array('error' => 'user exists');
                return $response->withJson($error,200);
            }else{
                $sql = "INSERT INTO users (username,email,password) VALUES (?,?,?)";
                $registeredUser = $this->container->db->prepare($sql)->execute([$username,$email,$password]);
                $result =  $this->container->db->lastInsertId();
                $val = [
                    'user_id' => $result,
                    'token' => $token
                ];
                return $response->withJson($val,200);
            }
        } catch (\PDOException $e) {
            //throw $th;
            echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
        }
    }
}