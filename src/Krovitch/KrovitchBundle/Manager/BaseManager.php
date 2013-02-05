<?php

namespace Krovitch\KrovitchBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Krovitch\KrovitchBundle\Utils\StringUtils;
use Symfony\Component\DependencyInjection\Container;

abstract class BaseManager
{
    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function save($object_to_persist)
    {
        $entity_manager = $this->getEntityManager();
        $entity_manager->persist($object_to_persist);
        $entity_manager->flush();
    }

    public function delete($mixed)
    {
        $object_to_delete = $mixed;

        if (!is_object($mixed)) {
            $object_to_delete = $this->find($mixed);

            if (!$object_to_delete) {
                throw new EntityNotFoundException();
            }
        }
        $this->getEntityManager()->remove($object_to_delete);
        $this->getEntityManager()->flush();
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    protected function getRepository($repositoryName = null)
    {
        // try to find automatically the manager name
        if (!$repositoryName) {
            $repositoryName = StringUtils::getEntityClassName($this);
        }
        $repositoryName = Container::camelize($repositoryName);
        // add krovitch prefix
        if (substr($repositoryName, 0, 7) != 'krovitch') {
            $repositoryName = 'KrovitchBundle:' . $repositoryName;
        }
        return $this->getEntityManager()->getRepository($repositoryName);
    }

    public function getEntityManager()
    {
        return $this->entity_manager;
    }
}