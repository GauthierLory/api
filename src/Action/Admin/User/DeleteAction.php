<?php


namespace App\Action\Admin\User;


use App\Action\Action;
use App\Entity\User;
use App\Security\Utils\AdminAccess;
use App\Service\User\UserService;

class DeleteAction extends Action
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
     * @param User $user
     */
    public function __invoke(User $user)
    {
        $this->userService->delete($user);
    }
}