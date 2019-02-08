<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class ProfileController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/account/{id}", name="profile_account")
     */
    public function account(User $user, Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $form =$this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        return $this->render('profile/account.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
