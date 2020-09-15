<?php

$app->add(new Tuupola\Middleware\JwtAuthentication([
    "ignore"=>["/api/user/login","/api/user/register"],
    "path" => ["/api"], /* or ["/api", "/admin"] */
    "secret" => "supersecretkeyyoushouldnotcommittogithub",
    "error"=>function ($response,$arguments)
    {
        $data["success"]= false;
        $data["response"]=$arguments["message"];
        $data["status_code"] = "401";

        return $response->withHeader("Content-type","application/json")
            ->getBody()->write(json_encode($data));
    }
]));