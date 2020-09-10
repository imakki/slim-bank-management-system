<?php

namespace Bank\Controllers\Auth;

use Slim\Http\Request;
use Slim\Http\Response;

class LoginController {
    
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function login(Request $request, Response $response) {
        $email = $request->getParam('email');
        $password = $request->getParam('password');

        if (empty($email) || empty($password)) {
            return $response->withJson(['errors' => ['email or password' => ['invalid']]], 422);
        }

        try {
            $sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password'";
            $user = $this->container->db->query($sql)->fetchAll(\PDO::FETCH_OBJ);

            if ($user) {
                echo json_encode($user);
            }else{
                echo "invalid credentials";
            }

        } catch (\PDOException $e) {
        echo '{"msg": {"resp": ' . $e->getMessage() . '}}';
        }
    // OK, default is 200
    return $response->withJson($result);
    }
}