<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

require_once('../vendor/autoload.php');

$app = new Application();
$app['password'] = 'guido';

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

$app->get('/', function(Request $request) use ($app) {
    /** @var Environment $twig */
    $twig = $app['twig'];
    return new Response(
        $twig->render(
            'index.twig'
        )
    );
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

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ .'/../views/',
]);

$app->run();
