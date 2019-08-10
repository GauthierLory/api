<?php

namespace App\Action\Admin;

use App\Action\Action;
use App\Security\Utils\AdminAccess;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation;

class IndexAction extends Action
{
    use AdminAccess;

    /**
     * @param Request $request
     * @return HttpFoundation\JsonResponse|HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $this->hasAccess();
        return $this->render('bo/pages/index.twig');
    }
}