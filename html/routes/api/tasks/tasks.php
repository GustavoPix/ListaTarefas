<?php

use Psr\Http\Message\ResponseInterface as Response;
//use \Slim\Http\Response as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use Source\Sql\Sql;

$app->get('/api/task', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id"=>"",
        "id_user"=>1,
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    if($object["id"] != "")
    {

        $task = $sql->select("SELECT * FROM tasks WHERE id = :id AND id_user = :id_user ORDER BY id",$object);

        $response->getBody()->write(json_encode(array(
            "success"=>true,
            "task"=>$task
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"id as null",
            "object"=>$object
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/tasks', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id_user"=>1,
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    
    $task = $sql->select("SELECT * FROM tasks WHERE id_user = :id_user ORDER BY id",$object);
    $response->getBody()->write(json_encode(array(
        "success"=>true,
        "tasks"=>$task
    )));
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/tasks/open', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id_user"=>1,
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    
    $task = $sql->select("SELECT * FROM tasks WHERE id_user = :id_user AND data_conclusao = '2000-01-01 00:00:00' ORDER BY id",$object);
    $response->getBody()->write(json_encode(array(
        "success"=>true,
        "tasks"=>$task
    )));
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/api/tasks/completed', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id_user"=>1,
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    
    $task = $sql->select("SELECT * FROM tasks WHERE id_user = :id_user AND data_conclusao != '2000-01-01 00:00:00' ORDER BY id",$object);
    $response->getBody()->write(json_encode(array(
        "success"=>true,
        "tasks"=>$task
    )));
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->delete('/api/task', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id"=>"",
        "id_user"=>1,
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    if($object["id"] != "")
    {

        $task = $sql->select("DELETE FROM tasks WHERE id = :id AND id_user = :id_user",$object);

        $response->getBody()->write(json_encode(array(
            "success"=>true
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"id as null",
            "object"=>$object
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->put('/api/task', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id"=>"",
        "id_user"=>1,
        "task"=>""
    );

    $object = array_merge($object,$_GET);



    $sql = new Sql();

    if($object["id"] != "" && $object["task"] != "")
    {

        $task = $sql->select("UPDATE tasks SET task = :task WHERE id = :id AND id_user = :id_user",$object);

        $response->getBody()->write(json_encode(array(
            "success"=>true,
            "task"=>$task
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"id as null",
            "object"=>$object
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/task/complete', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id"=>"",
        "id_user"=>1,
    );

    $object = array_merge($object,$_POST);

    $object["data_conclusao"] = "2000-01-01 00:00:00";


    $sql = new Sql();

    if($object["id"] != "")
    {

        $task = $sql->select("SELECT * FROM tasks WHERE id = :id AND id_user = :id_user AND data_conclusao = :data_conclusao",$object);

        if(count($task) > 0)
        {
            $sql->select("UPDATE tasks SET data_conclusao = now() WHERE id = :id AND id_user = :id_user",[
                ":id"=>$object["id"],
                ":id_user"=>$object["id_user"]
            ]);

            $response->getBody()->write(json_encode(array(
                "success"=>true,
                "task"=>$task
            )));
        }
        else
        {
            $response->getBody()->write(json_encode(array(
                "success"=>false,
                "message"=>"Task not found"
            )));
        }

        
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"id as null",
            "object"=>$object
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/api/task', function (Request $request, Response $response, $args) use($app) {
    

    $object = array(
        "id_user"=>1,
        "task"=>""
    );

    $object = array_merge($object,$_POST);



    $sql = new Sql();

    if($object["task"] != "")
    {
        $sql->select("INSERT INTO tasks(id_user,task) VALUES(:id_user,:task)",$object);

        $task = $sql->select("SELECT * FROM tasks WHERE task = :task AND id_user = :id_user ORDER BY id DESC LIMIT 1",$object);

        $response->getBody()->write(json_encode(array(
            "success"=>true,
            "task"=>$task
        )));
    }

    else
    {
        $response->getBody()->write(json_encode(array(
            "success"=>false,
            "message"=>"Task as null"
        )));
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

?>