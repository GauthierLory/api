<?php


namespace App\Action\Admin;


use App\Action\Action;

class IndexAction extends Action
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        return $this->render('bo/pages/index.twig');
    }
}