<?php
/**
 * Created by PhpStorm.
 * User: BPOGGI
 * Date: 08/03/2019
 * Time: 14:45
 */

namespace App\EventListener;


use App\Service\HistoriqueHelper;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineEvent implements EventSubscriber
{

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return string[]
     */
    public function getSubscribedEvents()
    {
        return array('prePersist', 'preUpdate', 'postPersist', 'postUpdate');//les événements écoutés
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        //Si c'est bien une entité Contact qui va être "persisté"
        if ($entity instanceof User) {
            //$entity->updateGmapData();//on met à jour les coordonnées via l'appel à google map
            return $entity;
        }
    }

    public function preUpdate(LifecycleEventArgs $args) {

        $historiquehelper = new HistoriqueHelper(EntityManagerInterface::class);
        $entity = $args->getEntity();
        $changeset = $args->getEntityManager()->getUnitOfWork()->getEntityChangeSet($entity);
        //Si c'est bien une entité Contact qui va être modifié
        if ($entity instanceof User) {
            //Si il y'a eu une mise a jour sur les propriétés en relation avec l'adresse (ici "address", "city" et "postalCode")
            if (array_key_exists("title", $changeset) || array_key_exists("description", $changeset) || array_key_exists("tag", $changeset)) {
                $historique = $historiquehelper->new_historique($this->getUser());
                $historiquehelper->new_modif($table="user", $champ="atta", "old", "new", $historique, $entity->getId());
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args){}

    public function postUpdate(LifecycleEventArgs $args){}
}