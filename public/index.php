<?php

use Libreria\Controller\LibriController;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

require_once('../vendor/autoload.php');
$app = new Application();
$app['password'] = 'guido';

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

//$app->before(function (Request $request, Application $app) {
//    $password = $request->headers->get('password');
//    if (empty($password)) {
//        return new Response('PASSWORD MANCANTE');
//    }
//
//    if ($password !== $app['password']) {
//        return new Response('PASSWORD ERRATA!');
//    }
//});

$twig = $app['twig'];
$db = $app['db'];

$app->get('/', function(Request $request) use ($app) {
    $controller = new LibriController($app);
    $risposta = $controller->indexAction();
    return new Response($risposta);
});

$app->post('/insert', function(Request $request) use ($app){
    $titolo = $request->request->get('titolo');
    $autore = $request->request->get('autore');
    $prezzo = $request->request->get('prezzo');
    $controller = new LibriController($app);
    $risposta = $controller->insertAction($titolo,$autore,$prezzo);
    return new \Symfony\Component\HttpFoundation\RedirectResponse('/');
});

$app->post('/modifica', function(Request $request) use ($app){
    $id = $request->request->get('id');
    $titolo = $request->request->get('titolo');
    $autore = $request->request->get('autore');
    $prezzo = $request->request->get('prezzo');
    $controller = new LibriController($app);
    $controller = new LibriController($app);
    $risposta = $controller->modificaAction($id,$titolo,$autore,$prezzo);
    return new \Symfony\Component\HttpFoundation\RedirectResponse('/');
});

$app->post('/save', function(Request $request) use ($app) {
    $id = $request->request->get('id_edit');
    if($id) {
        $controller = new LibriController($app);
        $risposta = $controller->editAction($id);
        return new Response($risposta);
    } else {
        $controller = new LibriController($app);
        $risposta = $controller->editAction();
        return new Response($risposta);
    }
});

$app->post ('/delete' ,function(Request $request) use ($app) {
    $id = $request->request->get('id');
    $controller = new LibriController($app);
    $risposta = $controller->deleteAction($id);
    return new \Symfony\Component\HttpFoundation\RedirectResponse('/');
});

$app->run();
