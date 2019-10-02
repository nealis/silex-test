<?php

use Libreria\Controller\LibroController;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once('../vendor/autoload.php');
$app = new Application();

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ .'/../views/',
]);

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
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

$app->post('/insert', function(Request $request) use ($app){
    $titolo = $request->request->get('titolo');
    $autore = $request->request->get('autore');
    $prezzo = $request->request->get('prezzo');
    $controller = new LibroController($app);
    $controller->insertAction($titolo,$autore,$prezzo);
    return new RedirectResponse('/');
});

$app->post('/modifica', function(Request $request) use ($app){
    $id = $request->request->get('id');
    $titolo = $request->request->get('titolo');
    $autore = $request->request->get('autore');
    $prezzo = $request->request->get('prezzo');
    $controller = new LibroController($app);
    $controller->modificaAction($id,$titolo,$autore,$prezzo);
    return new RedirectResponse('/');
});

$app->post('/edit', function(Request $request) use ($app) {
    $id = $request->request->get('id_edit');
    if($id) {
        $controller = new LibroController($app);
        $risposta = $controller->editAction($id);
        return new Response($risposta);
    } else {
        $controller = new LibroController($app);
        $risposta = $controller->editAction();
        return new Response($risposta);
    }
});

$app->post ('/delete' ,function(Request $request) use ($app) {
    $id = $request->request->get('id');
    $controller = new LibroController($app);
    $controller->deleteAction($id);
    return new RedirectResponse('/');
});

$app->run();
