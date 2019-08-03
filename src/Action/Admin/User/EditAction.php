<?php


namespace App\Action\Admin\User;


use App\Action\Action;
use App\Entity\User;
use App\Form\UserType;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditAction extends Action
{
    /** @var UserService  */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @param Request $request
     * @param User|null $user
     * @return Response
     */
    public function __invoke(Request $request, User $user = null): Response
    {
        if (!$user) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->editOrCreate($user);
            return $this->redirectToRoute('users::list');
        }
        return $this->render('bo/pages/user/edit.twig');
    }
}