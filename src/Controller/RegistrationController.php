<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationType;
use App\Security\LoginFormAuthAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Traits\CaptureIpTrait;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register",  methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthAuthenticator $authenticator): Response
    {
        $user = new User();
        $form= $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsActivate(true);
            $user->setPassword($passwordEncoder->encodePassword($user,$form->get('plainPassword')->getData()));

            // GET IP ADDRESS
//            $ipAddress = new CaptureIpTrait();
//            if($user->getAddressip()==null OR $user->getAddressip()==""){
//                $user->setAddressip($ipAddress->getClientIp());
//            }
//            Attach Avatar to User
            if(!empty($user->getAvatar())){
                $file = $user->getAvatar();
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('photos_directory'), $fileName);
                $user->setAvatar($fileName);
            }
            else{
                $alea = rand(0,23);
                $user->setAvatar("icons".$alea.".png");
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
