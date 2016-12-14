<?php

namespace FS\PaysBundle\EventListener;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\EntityManager;
use FS\PaysBundle\Entity\Pays;

class UpdatePopulation
{

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // only act on some "Pays" entity
        if (!$entity instanceof Pays) {
            return;
        }


        /** @var EntityManager $entityManager */
        $entityManager = $args->getEntityManager();
        $continent = $entity->getContinent();
        $continent->updatePopulation($entity->getPopulation() - $entity->getOldPopulation());
        $entityManager->flush();
    }
}