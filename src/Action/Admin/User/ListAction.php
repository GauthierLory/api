<?php


namespace App\Action\Admin\User;


use App\Action\Action;
use App\Security\Utils\AdminAccess;
use App\Table\Admin\UserDatatable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation;

class ListAction extends Action
{
    use AdminAccess;

    /** @var UserDatatable  */
    private $userDatatable;

    /**
     * @param UserDatatable $userDatatable
     */
    public function __construct(UserDatatable $userDatatable)
    {
        $this->userDatatable = $userDatatable;
    }

    /**
     * @param Request $request
     * @return HttpFoundation\JsonResponse|HttpFoundation\Response
     */
    public function __invoke(Request $request)
    {
        $this->hasAccess();
        $this->userDatatable->handleRequest($request);
        if ($this->userDatatable->isCallback()) {
            return $this->userDatatable->response();
        }
        return $this->render('bo/pages/user/list.twig',
            ['datatable' => $this->userDatatable->render()]
        );
    }
}