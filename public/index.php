<?php

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

$app->get('/', function(Request $request) use ($twig, $db) {
    
    $sql = "SELECT * FROM libri";

    $libri = $db->fetchAll($sql);
    foreach ($libri as $libro) {
        echo $libro['title']."</br> ";
    }
    return new Response(
        $twig->render(
            'index.twig'
        )
    );
});

$app->get('/libri', function (request $request) use ($app) {

});

$app->get('/salutami/{nomeUtente}', function(Request $request, $nomeUtente) use ($app) {
    /** @var Environment $twig */
    $twig = $app['twig'];
    return new Response(
        $twig->render(
            'saluto.twig', [
                'nomeUtente' => $nomeUtente
            ]
        )
    );
});


$app->run();
