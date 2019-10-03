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
        $model = new Libro($this->app['db']);

        $data = $model->read();
        /** @var Environment $twig */
        $twigEnvironment = $this->app['twig'];
        return $twigEnvironment->render(
            'index.twig', [
                'libri' => $data,
            ]
        );
    }

    public function editAction($id = null)
    {
        if ($id) {
            $model = new Libro($this->app['db']);
            $libro = $model->readById($id);
            $twigEnvironment = $this->app['twig'];
            return $twigEnvironment->render(
                'edit.twig', [
                    'libro' => $libro,
                ]
            );
        } else {
            $twigEnvironment = $this->app['twig'];
            return $twigEnvironment->render(
                'edit.twig'
            );
        }
    }

    public function modificaAction($id, $titolo, $autore, $prezzo)
    {
        $model = new Libro($this->app['db']);
        $insertResult = $model->edit($id,$titolo,$autore,$prezzo);
        if($insertResult){
            return 'Successo';
        } else{
            return 'Insert non riuscito';
        }
    }

    public function insertAction($titolo,$autore,$prezzo)
    {
        $model = new Libro($this->app['db']);
        $insertResult = $model->insert($titolo,$autore,$prezzo);
        if($insertResult){
            return 'Successo';
        } else{
            return 'Insert non riuscito';
        }
    }

    public function deleteAction($id)
    {
        $model = new Libro($this->app['db']);
        $deleteResult = $model->delete($id);
        if($deleteResult){
            return 'Successo';
        } else{
            return 'Delete non riuscita';
        }
    }

    public function readAction()
    {
        $model = new Libro($this->app['db']);
        $data = $model->read();
        $count = count($data);
        $array = [
            'success' => $count >= 0,
            'data' => $data,
            'errors' => $count <= 0 ? ["Errore in lettura"] : [],
        ];
        return $array;
    }
}
