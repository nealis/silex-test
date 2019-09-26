<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once('../vendor/autoload.php');

$app = new Silex\Application();

$app->get('/', function(Request $request) {
        return new Response(
            '<html>
        <body style="
            background-color: black; 
            color: white;">
                Ciao!
            </body>
        </html>'
        );
});

$app->run();
