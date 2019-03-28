<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/{page<\d>?1}", name="home")
     */
    public function index(ArticleRepository $articleRepository, $page)
    {
        $limit = 9;

        $start = $page * $limit -$limit;

        $total = count($articleRepository->findAll());

        $pages = ceil($total / $limit);

        return $this->render('home/index.html.twig', [
            'articles' => $articleRepository->findBy([],['id'=>'DESC'],$limit,$start),
            'pages' => $pages,
            'page' => $page
        ]);
    }
}
