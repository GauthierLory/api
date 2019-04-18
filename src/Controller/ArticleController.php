<?php

namespace App\Controller;

use App\Entity\ArticlePicture;
use App\Entity\Article;
use App\Entity\ArticleLike;
use App\Entity\Comment;
use App\EventListener\DoctrineEvent;
use App\Form\ArticlePictureType;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticlePictureRepository;
use App\Repository\ImageRepository;
use App\Repository\ArticleLikeRepository;
use App\Repository\ArticleRepository;
use App\Service\HistoriqueHelper;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\DependencyInjection\Argument\ServiceLocator;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 * @IsGranted("ROLE_USER")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("", name="article_index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_new", methods={"GET","POST"})
     */
    public function new(Request $request, ObjectManager $manager, ImageRepository $imageRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTime());
//            foreach ($article->getImages() as $image){
//                $image->setarticle($article);
//                $manager->persist($image);
//            }
            $article->setUser($this->getUser());
            $manager->persist($article);
            $manager->flush();

//            return $this->redirectToRoute('article_index');
            return $this->redirectToRoute('article_picture_new',array(
                'slug' => $article->getSlug(),
                'id' => $article->getId()
            ));
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'images' => $imageRepository->findAll()
        ]);
    }

    /**
     *@Route("/{slug}/{id}/picture",name="article_picture_new", methods={"GET","POST"})
     */
    public function newPicture($slug, Article $article,Request $request,ArticleRepository $repo, ObjectManager $manager){
        $article = $repo->findOneBySlug($slug);
        $picture = new ArticlePicture;
        $formP = $this->createForm(ArticlePictureType::class, $picture);
        $formP->handleRequest($request);

        if ($formP->isSubmitted() && $formP->isValid()) {
            $picture->setArticle($article);
//            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $formP->get('picture')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

//            $pictureDir = $this->container->getParameter('kernel.root_dir').'./public/uploads/pictures';
//            $file->move($pictureDir, $fileName);

            try {
                $file->move(
                    $this->getParameter('pictures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                $this->addFlash( 'danger' , $e->getMessage());
            }

            $picture->setPicture($fileName);


//            $file = $formP->get('file')->getData();
//
////            $fileName = $file->getClientOriginalName();
////            $fileMime = $file->g
//
//            try {
//                $file->move(
//                    $this->getParameter('pictures_directory'),
//                    $fileName
//                );
//            } catch (FileException $e) {
//                $this->addFlash( 'danger' , $e->getMessage());
//            }
//
//            $picture->setPicture($fileName);

//            $picture->setPath($file);
//            $picture->setPath($file);
//            $picture->setPath($file);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($picture);
            $entityManager->flush();
        }

        return $this->render('article/picture.html.twig', array(
            'formP' => $formP->createView()
        ));
    }

    /**
     * @Route("/{slug}/{id}", name="article_show", methods={"GET","POST"})
     */
    public function show($slug, ArticleRepository $repo, Request $request, ArticlePictureRepository $repository): Response
    {
        $article = $repo->findOneBySlug($slug);
        $articlePictures = $repository->findAll();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                $comment->setAuthor($this->getUser());
                $comment->setArticle($article);
//                dump($form);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comment);
                $entityManager->flush();

        }

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'articlePictures' => $articlePictures,
            'articles' => $repo->findBy([],[],4),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}/{id}/edit", name="article_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER') and user == article.getUser()", message="This article is not yours")
     */
    public function edit(Request $request, Article $article, ObjectManager $manager, $slug, ArticleRepository $repo, HistoriqueHelper $historiqueHelper, DoctrineEvent $devent): Response
    {

        $article = $repo->findOneBySlug($slug);
        $old_article = "old article";

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($request->request->get('edit')) {
                $this->getDoctrine()->getManager()->flush();

                $t = $devent->preUpdate();
                $new_article = "new roduct";
                $historique = $historiqueHelper->new_historique($this->getUser());
                $historiqueHelper->new_modif($table="user", $champ="atta", $t, $new_article, $historique, $article->getId());

                return $this->redirectToRoute('article_index', [
                    'id' => $article->getId(),
                ]);
            }
            $manager->persist($article);
            $manager->flush();
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     *
     * @Route("/like/{id}/article", name="article_like")
     * @param Article $article
     * @param ObjectManager $manager
     * @param ArticleLikeRepository $likeRepo
     * @return Response
     */
    public function like(Article $article, ObjectManager $manager, ArticleLikeRepository $likeRepo): Response {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if ($article->isLikedByUser($user)){
            $like = $likeRepo->findOneBy([
                'article' => $article,
                'user' => $user,
            ]);
            $manager->remove($like);
            $manager->flush();

            /*return $this->json([
                'code' => 200,
                'message' => 'like bien supprimé',
                'likes' => $likeRepo->count(['article' => $article])
            ], 200);*/
            return $this->redirectToRoute('home');
        }

        $like = new ArticleLike();
        $like->setarticle($article)
            ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        /*return $this->json([
            'code' => 200,
            'message' => 'Ca marche bien',
            'likes' => $likeRepo->count(['article' => $article])
        ], 200);*/

        return $this->redirectToRoute('home');
    }
}
