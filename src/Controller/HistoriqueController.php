<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Historique;
use App\Entity\HistoriqueModif;
use App\Repository\HistoriqueRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\DateTime;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/historique")
 * @IsGranted("ROLE_USER")
 */
class HistoriqueController extends AbstractController
{
    /**
     * @Route("", name="historique_index", methods={"GET"})
     */
    public function index(HistoriqueRepository $repo)
    {
        return $this->render('historique/index.html.twig', [
            'historique' =>  $repo->findAll(),
            'controller_name' => 'HistoriqueController',
        ]);
    }


    public function new_historique(ObjectManager $manager, $user){
        $historique = new Historique();
        $historique->setUser($user);
        $historique->setModifiedDate(new  \DateTime());
        $manager->persist($historique);
        $manager->flush();

        return $historique;
    }

    public function new_review(ObjectManager $manager, $table, $champ, $old, $new, $historique){
        $historique_modif = new HistoriqueModif();
        $historique_modif->setTableModif($table);
        $historique_modif->setChampModif($champ);
        $historique_modif->setOldValue($old);
        $historique_modif->setNewValue($new);
        $historique_modif->setHistorique($historique);
        $manager->persist($historique_modif);
        $manager->flush();
    }

    public function new_product(){

    }

    //element : Review Product etc..
    public function new_modif(ObjectManager $manager, $historique_id, $element,$table){
        $modif = new HistoriqueModif();
        $modif->setTableModif($table);
        $manager->persist($modif);
        $manager->flush();
    }
}
