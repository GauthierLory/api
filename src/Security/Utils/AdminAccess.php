<?php


namespace App\Security\Utils;


use App\Security\Admin\AdminVoter;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trait AdminAccess
 * @property ContainerInterface $container
 */
trait AdminAccess
{
    use ControllerTrait;

    public function hasAccess($role = null): void
    {
        $authChecker = $this->container->get('security.authorization_checker');
        if (!$authChecker->isGranted(AdminVoter::ACCESS)) {
            throw $this->createAccessDeniedException();
        }
    }
}