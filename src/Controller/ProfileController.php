<?php

namespace App\Controller;

use App\Entity\Upload;
use App\Entity\User;
use App\Form\ProfileType;
use App\Form\UploadType;
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
     * @Route("/profile/account", name="profile_account")
     */
    public function account(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();
        $form =$this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }


//        $upload = new Upload();
//        $formUpload = $this->createForm(UploadType::class, $upload);
//        $formUpload->handleRequest($request);
//
//        if ($formUpload->isSubmitted() && $formUpload->isValid()){
//            $upload->setCreatedAt(new \DateTime());
//            $upload->setUser($this->getUser());
//
//            $entityManager = $this->getDoctrine()->getManager();
//            $entityManager->persist($upload);
//            $entityManager->flush();
//        }

        return $this->render('profile/account.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
//            'upload' => $upload,
            'form' => $form->createView(),
//            'formUpload' => $formUpload->createView()
        ]);
    }
}
