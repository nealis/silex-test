<?php

namespace Libreria\Controller;

use Libreria\Model\Libri;
use Silex\Application;
use Twig\Environment;

class LibriController
{
    /** @var Application */
    private $app;

    /**
     * LibriController constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {
        $model = new Libri($this->app['db']);
        $data = $model->read();

        /** @var Environment $twig */
        $twigEnvironment = $this->app['twig'];
        return $twigEnvironment->render(
            'index.twig'
        );
    }
}
