<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

/*registrar funciones*/
spl_autoload_register(function ($classname) {
    require ("modelo/" . $classname . ".php");
});

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$config['db']['host']   = "us-cdbr-azure-east-c.cloudapp.net";
$config['db']['user']   = "beae76eb76258b";
$config['db']['pass']   = "9da28d5b";
$config['db']['dbname'] = "bolsacr";

/*incluir configuraciones en el app*/
$app = new \Slim\App(["settings" => $config]);

/*conector BD*/
$container = $app->getContainer();
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['view'] = new \Slim\Views\PhpRenderer("templates/");

$app->get('/{tabla}', function (Request $request, Response $response) {
    $tabla = $request->getAttribute('tabla');
    $grafico = new grafico($this->db);
    $output = $grafico->get($tabla);
    $response = $response->withJson($output);
	//$response = $this->view->render($response, "grafico.phtml", ["output" => $output, "tabla" => $tabla]);
    return $response;
});
$app->run();