<?php

use Libreria\Controller\LibroController;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Provider\DoctrineServiceProvider;

require_once('../vendor/autoload.php');
$app = new Application();

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ .'/../views/',
]);

$app->register(new DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'   => 'pdo_mysql',
        'host' => '127.0.0.1',
        'dbname' => 'libri',
        'user' => 'root',
        'password' => 'root',
        'port' => 8889,
    ),
));

$twig = $app['twig'];
$db = $app['db'];

$app->get('/', function(Request $request) use ($app) {
    $controller = new LibroController($app);
    $risposta = $controller->indexAction();
    return new Response($risposta);
});

$app->post('/save', function(Request $request) use ($app){
    $id = $request->request->get('id');
    $titolo = $request->request->get('titolo');
    $autore = $request->request->get('autore');
    $prezzo = $request->request->get('prezzo');
    $controller = new LibroController($app);
    if ($id == null) {
        $result = $controller->insertAction($titolo,$autore,$prezzo);
    } else {
        $result = $controller->modificaAction($id, $titolo, $autore, $prezzo);
    }
    return new JsonResponse($result);
});

$app->post ('/delete' ,function(Request $request) use ($app) {
    $id = $request->request->get('id');
    $controller = new LibroController($app);
    $result = $controller->deleteAction($id);
    return new JsonResponse($result);
});

$app->post ('/read', function (Request $request) use ($app) {
    $filters = $request->request->get('filters');
    if (is_null($filters)) {
        $filters = [
            'title' => '',
            'author' => '',
        ];
    }
    $controller = new LibroController($app);
    $result = $controller->readAction($filters);
    return new JsonResponse($result);
});


$app->run();
