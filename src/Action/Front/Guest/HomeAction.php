<?php

namespace App\Action\Front\Guest;

use App\Action\Action;

class HomeAction extends Action
{
    public function __construct()
    {
    }

    public function __invoke()
    {
        return $this->render('front/pages/home.twig');
    }
}