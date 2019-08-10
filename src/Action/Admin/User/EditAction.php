<?php


namespace App\Action\Admin\User;


use App\Action\Action;
use App\Entity\User;
use App\Form\UserType;
use App\Security\Utils\AdminAccess;
use App\Service\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditAction extends Action
{
    use AdminAccess;

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
        $this->hasAccess();
        if (!$user) {
            $user = new User();
        }
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->editOrCreate($user);
            return $this->redirectToRoute('bo::user::list');
        }
        return $this->render('bo/pages/user/edit.twig', [
            'form' => $form->createView()
        ]);
    }
}