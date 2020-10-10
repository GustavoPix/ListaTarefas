<?php

use Psr\Http\Message\ResponseInterface as Response;
//use \Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Source\Sql\Sql;
use Source\Security\Encrypt;



$app->post('/api/user', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "name"=>"",
        "email"=>"",
        "pass"=>""
    );

    $object = array_merge($object,$_POST);

    $sql = new Sql();

    if($object["name"] != "" && $object["email"] != "" && $object["pass"] != "")
    {
        $prev = $sql->select("SELECT id,email FROM users WHERE email = :email",[
            ":email"=>$object["email"]
        ]);
        if(count($prev) == 0)
        {
            $object["pass"] = Encrypt::encryptData($object["pass"]);

            $sql->select("INSERT INTO users(name,email,pass) VALUES(:name,:email,:pass)",$object);
            $user = $sql->select("SELECT id,name,email FROM users WHERE email = :email ORDER BY id DESC LIMIT 1",[
                ":email"=>$object["email"]
            ]);

            $response->getBody()->write(json_encode(array(
                "success"=>true,
                "user"=>$user
            )));
        }
        else
        {
            $response->getBody()->write(json_encode(array(
                "success"=>false,
                "message"=>"User already exists",
                "object"=>$object
            )));
        }

    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"One or more arguments are null",
            "object"=>$object
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

?>