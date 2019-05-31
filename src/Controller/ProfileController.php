<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\Upload;
use App\Entity\User;
use App\Form\PasswordUpdateType;
use App\Form\ProfileType;
use App\Form\UploadType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class ProfileController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_page")
     */
    public function index(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $passwordUpdate = new  PasswordUpdate();
        $formPassword = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()){
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())){
//                echo 'no !';
                $this->addFlash(
                    'error',"No !"
                );
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',"Votre mdp est été modifié"
                );
                return $this->redirectToRoute('profile_password');
            }
        }

        $formProfile =$this->createForm(ProfileType::class, $user);
        $formProfile->handleRequest($request);

        if ($formProfile->isSubmitted() && $formProfile->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        $user = $this->getUser();
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'formPassword' => $formPassword->createView(),
            'formProfile' => $formProfile->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/comments", name="profile_comment")
     */
    public function comments()
    {
        $user = $this->getUser();
        return $this->render('profile/comments.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/account", name="profile_account")
     */
    public function account(Request $request)
    {
        $user = $this->getUser();
        $formProfile =$this->createForm(ProfileType::class, $user);
        $formProfile->handleRequest($request);

        if ($formProfile->isSubmitted() && $formProfile->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('profile/account.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'formProfile' => $formProfile->createView(),
        ]);
    }

    /**
     * @Route("/profile/password-update", name="profile_password")
     */
    public function passwordUpdate(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $user = $this->getUser();
        $passwordUpdate = new  PasswordUpdate();
        $formPassword = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $formPassword->handleRequest($request);

        if ($formPassword->isSubmitted() && $formPassword->isValid()){
            if (!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())){
//                echo 'no !';
                $this->addFlash(
                    'error',"No !"
                );
            }else{
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($hash);
                $manager->persist($user);
                $manager->flush();
                $this->addFlash(
                    'success',"Votre mdp est été modifié"
                );
                return $this->redirectToRoute('profile_password');
            }
        }

        return $this->render('profile/passwordUpdate.html.twig',[
            'user' => $user,
            'formPassword' => $formPassword->createView(),
        ]);
    }

}
