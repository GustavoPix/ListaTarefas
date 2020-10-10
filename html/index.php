<?php

use Psr\Http\Message\ResponseInterface as Response;
//use \Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Source\Sql\Sql;
use Source\Security\Encrypt;
use Source\Auxiliares\Auxiliares;

require __DIR__ . '/vendor/autoload.php';

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add routes
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write('<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <p>Token: <span>' . (isset($_SESSION['token']) ? $_SESSION['token'] : '') . '</span></p>
        <form action="/login" method="POST">
            <p>Username: <input type="text" name="email" /></p>
            <p>pass: <input type="password" name="pass" /></p>
            <p><input type="submit" name="submit" value="Login" /></p>
        </form>
    </body>
    </html>');
    return $response;
});

$app->post('/login', function (Request $request, Response $response) {
    
    $sql = new Sql();
    
    $pass = Encrypt::encryptData($_POST["pass"]);
    
    $user = $sql->select("SELECT id,email FROM users WHERE email = :email AND pass = :pass",[
        ":email"=>$_POST["email"],
        ":pass"=>$pass
    ]);

    if(count($user) > 0)
    {
        $token = "";
        while($token == "")
        {
            $token = Auxiliares::randomString(100);
            $aux = $sql->select("SELECT * FROM sessions WHERE token = :token",[
                ":token"=>$token
            ]);

            if(count($aux) > 0)
            {
                $token = "";
            }
            else
            {
                $sql->select("INSERT INTO sessions(id_user,token) VALUES(:id_user,:token)",[
                    ":id_user"=>$user[0]["id"],
                    ":token"=>$token
                ]);
            }
        }
        $_SESSION["token"] = $token;

        $response->getBody()->write(json_encode(array(
            "success"=>true,
            "token"=>$token
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"Email or Password not exist"
        )));
    }

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/logout', function (Request $request, Response $response) {
    
    $sql = new Sql();
    
    
    $user = $sql->select("SELECT id,email FROM users WHERE email = :email",[
        ":email"=>$_POST["email"]
    ]);

    if(count($user) > 0)
    {
        session_destroy();
    }

    $response->getBody()->write(json_encode(array(
        "success"=>true,
        "user"=>$user
    )));

    return $response->withHeader('Content-Type', 'application/json');
});


require "./routes/routes.php";

$app->run();

?>