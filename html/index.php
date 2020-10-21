<?php

use Psr\Http\Message\ResponseInterface as Response;
//use \Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\NotFoundException;
use Slim\Factory\AppFactory;

use Source\MyCustomErrorRenderer;
use Source\Sql\Sql;
use Source\Security\Encrypt;
use Source\Auxiliares\Auxiliares;


require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/vendor/smarty/smarty/libs/Smarty.class.php';

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addRoutingMiddleware();
//$app->addErrorMiddleware(true, true, true);

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$errorMiddleware->setErrorHandler(\Slim\Exception\HttpNotFoundException::class, function (
    \Psr\Http\Message\ServerRequestInterface $request,
    \Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) {
    $response = new \Slim\Psr7\Response();
    $response->getBody()->write('');

    $smarty = new Smarty();
    $smarty->setLeftDelimiter("{{{");
        $smarty->setRightDelimiter("}}}");
        $smarty->setAutoLiteral(false);
    $smarty->assign('msn', 'Página não existe');
    $smarty->display('resetPasswordInvalid.tpl');

    return $response->withStatus(404);
});

// Add routes
$app->get('/', function (Request $request, Response $response) {

    $smarty = new Smarty();
    $smarty->setLeftDelimiter("{{{");
        $smarty->setRightDelimiter("}}}");
        $smarty->setAutoLiteral(false);
    $smarty->assign('teste', 'Olá mundo!');
    
    $smarty->display('index.tpl');
    //$smarty->display('tarefas.tpl');
    return $response;
});

$app->get('/tarefas', function (Request $request, Response $response) {

    $smarty = new Smarty();
    $smarty->setLeftDelimiter("{{{");
        $smarty->setRightDelimiter("}}}");
        $smarty->setAutoLiteral(false);
    $smarty->assign('teste', 'Olá mundo!');
    
    //$smarty->display('index.tpl');
    $smarty->display('tarefas.tpl');
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
            "token"=>$user[0]["id"] . "_" . $token
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
$app->get('/login/token', function (Request $request, Response $response) {
    
    $sql = new Sql();
    
    $data = new DateTime(' -7 day');
    $sql->select("DELETE FROM sessions WHERE data_criacao < :data",[
        ":data"=> $data->format('d-m-Y H:i:s')
    ]);

    $user = $sql->select("SELECT * FROM sessions WHERE token = :token AND id_user = :id_user",[
        ":token"=>$_GET["token"],
        ":id_user"=>$_GET["id_user"]
    ]);


    if(count($user) > 0)
    {
        $response->getBody()->write(json_encode(array(
            "success"=>true
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"Invalid Token"
        )));
    }

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/logout', function (Request $request, Response $response) {
    
    $sql = new Sql();
    
    
    $sql->select("DELETE FROM sessions WHERE token = :token",[
        ":token"=> $_POST["token"]
    ]);

    session_destroy();
    
    $response->getBody()->write(json_encode(array(
        "success"=>true
    )));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/resetpassword', function (Request $request, Response $response) {
    
    $sql = new Sql();

    $smarty = new Smarty();
    $smarty->setLeftDelimiter("{{{");
        $smarty->setRightDelimiter("}}}");
        $smarty->setAutoLiteral(false);
    $smarty->assign('msn', 'Link expirado');

    if(isset($_GET["token"]))
    {
        $data = new DateTime(' -2 hour');
        $sql->select("DELETE FROM resetPass WHERE data_criacao < :data",[
            ":data"=> $data->format('d-m-Y H:i:s')
        ]);

        $aux = $sql->select("SELECT id_user FROM resetPass WHERE token = :token",[
            ":token"=>$_GET["token"]
        ]);
        if(count($aux) > 0)
        {
            $smarty->display('resetPassword.tpl');
        }
        else
        {
            $smarty->display('resetPasswordInvalid.tpl');
        }
    }
    else
    {
        $smarty->display('resetPasswordInvalid.tpl');
    }

    
    //$smarty->display('tarefas.tpl');
    return $response;
});

$app->post('/resetpassword', function (Request $request, Response $response) {
    
    $sql = new Sql();

    $object = array(
        "email"=>""
    );

    $object = array_merge($object,$_POST);

    $user = $sql->select("SELECT id,name FROM users WHERE email = :email",[
        ":email"=>$object["email"]
    ]);

    if(count($user) > 0)
    {
        $token = Auxiliares::randomString(100);

        $data = new DateTime(' -2 hour');
        $sql->select("DELETE FROM resetPass WHERE data_criacao < :data OR token = :token",[
            ":data"=> $data->format('d-m-Y H:i:s'),
            ":token"=> $token
        ]);

        $sql->select("INSERT INTO resetPass(id_user,token) VALUES(:id_user,:token)",[
            ":id_user"=> $user[0]["id"],
            ":token"=> $token
        ]);

        $frase = 'Você solicitou a troca de senha da <b>Lista de Tarefas</b></br>Clique o link abaixo para digitar sua nova senha</br></br><a href="' . ROUTE . "/resetpassword?token=" . $token .'">Clique aqui</a>';

        
        $response->getBody()->write(json_encode(array(
            "success"=>Auxiliares::sendEmail($object["email"],$user[0]["name"],"Trocar senha",$frase)
        )));
    }
    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false
        )));
    }
    

    return $response->withHeader('Content-Type', 'application/json');
});
$app->post('/resetpassword/token', function (Request $request, Response $response) {
    
    $sql = new Sql();

    $object = array(
        "token"=>"",
        "pass"=>""
    );

    $object = array_merge($object,$_POST);

    $data = new DateTime(' -2 hour');
    $sql->select("DELETE FROM resetPass WHERE data_criacao < :data",[
        ":data"=> $data->format('d-m-Y H:i:s')
    ]);

    $user = $sql->select("SELECT id_user FROM resetPass WHERE token = :token",[
        ":token"=>$object["token"]
    ]);

    if(count($user) > 0)
    {
        $object["pass"] = Encrypt::encryptData($object["pass"]);
        $sql->select("UPDATE users SET pass = :pass WHERE id = :id",[
            ":pass"=>$object["pass"],
            ":id"=>$user[0]["id_user"]
        ]);

        $sql->select("DELETE FROM resetPass WHERE token = :token",[
            ":token"=> $object["token"]
        ]);
        
        
        $response->getBody()->write(json_encode(array(
            "success"=>true
        )));
    }
    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false
        )));
    }
    

    return $response->withHeader('Content-Type', 'application/json');
});


require "./routes/routes.php";

$app->run();

?>