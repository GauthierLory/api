<?php


namespace App\Action\Admin\User;


use App\Action\Action;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Response;

class ListAction extends Action
{
    /** @var UserService  */
    private $userService;

    /**
     * @param UserService $userService*
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @return Response
     */
    public function __invoke(): Response
    {
        return $this->render('bo/pages/user/list.twig', [
            'users' => $this->userService->findAll()
        ]);
    }
}