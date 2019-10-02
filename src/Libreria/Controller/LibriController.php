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
            'index.twig',
            [
                'libri' => $data,
            ]
        );
    }

    public function editAction($id = null)
    {
        if($id) {
        $model = new Libri($this->app['db']);
        $data = $model->readPerId($id);
        $twigEnvironment = $this->app['twig'];
        return $twigEnvironment->render(
            'edit.twig',
            [
                'id'=> $data[0]['id'],
                'titolo'=> $data[0]['title'],
                'autore'=> $data[0]['author'],
                'prezzo'=> $data[0]['price'],
            ]
        ); } else {
            $twigEnvironment = $this->app['twig'];
            return $twigEnvironment->render(
                'edit.twig'
            );
        }
    }

    public function modificaAction($id,$titolo,$autore,$prezzo)
    {
        $model = new Libri($this->app['db']);
        $insertResult = $model->edit($id,$titolo,$autore,$prezzo);
        if($insertResult){
            return 'Successo';
        } else{
            return 'Insert non riuscito';
        }
    }

    public function insertAction($titolo,$autore,$prezzo)
    {
        $model = new Libri($this->app['db']);
        $insertResult = $model->insert($titolo,$autore,$prezzo);
        if($insertResult){
            return 'Successo';
        } else{
            return 'Insert non riuscito';
        }
    }

    public function deleteAction($id)
    {
        $model = new Libri($this->app['db']);
        $deleteResult = $model->delete($id);
        if($deleteResult){
            return 'Successo';
        } else{
            return 'Delete non riuscita';
        }
    }
}
