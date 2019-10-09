<?php

namespace Libreria\Controller;

use Libreria\Model\Libro;
use Silex\Application;
use Twig\Environment;

class LibroController
{
    /** @var Application */
    private $app;

    /**
     * LibroController constructor.
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function indexAction()
    {
        /** @var Environment $twig */
        $twigEnvironment = $this->app['twig'];
        return $twigEnvironment->render(
            'index.twig'
        );
    }

    public function modificaAction($id, $titolo, $autore, $prezzo)
    {
        $model = new Libro($this->app['db']);
        $modificaResult = $model->edit($id, $titolo, $autore, $prezzo);
        $array = [
            'success' => $modificaResult != 0,
            'errors' => $modificaResult == 0,
        ];
        return $array;
    }

    public function insertAction($titolo, $autore, $prezzo)
    {
        $model = new Libro($this->app['db']);
        $insertResult = $model->insert($titolo, $autore, $prezzo);
        $array = [
            'success' => $insertResult != 0,
            'errors' => $insertResult == 0,
        ];
        return $array;
    }

    public function deleteAction($id)
    {
        $model = new Libro($this->app['db']);
        $deleteResult = $model->delete($id);
        $array = [
            'success' => $deleteResult != 0,
            'errors' => $deleteResult == 0,
        ];
        return $array;
    }

    public function readAction($filters, $page, $column, $order)
    {

        $model = new Libro($this->app['db']);
        $data = $model->read($filters, $page, $column, $order);
        $count = count($data);
        $array = [
            'success' => $count >= 0,
            'data' => $data[0],
            'count' => $data[1],
            'errors' => $count <= 0 ? ["Errore in lettura"] : [],
        ];
        return $array;
    }
}

