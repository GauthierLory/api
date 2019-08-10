<?php


namespace App\Action\Admin\Tools;


use App\Action\Action;

class BreadcrumbAction extends Action
{
    public function __invoke()
    {
        return $this->render('bo/include/breadscrumb.twig');
    }
}