<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;

class BaseRepository extends ServiceEntityRepository
{
    protected $logger;

    /**
     * CompanyRepository constructor.
     * @param ManagerRegistry $registry
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, @constant(get_class($this).'::ENTITY_CLASS'));
        $this->logger = $logger;
    }

    /**
     * @return mixed
     */
    private function getEntityClass(){
        return @constant(get_class($this).'::ENTITY_CLASS');
    }

    /**
     * @param EntityInterface $entity
     * @return bool
     */
    public function save(EntityInterface $entity)
    {
        $entityManager = $this->getEntityManager();
        try {
            $entityManager->persist($entity);
            $entityManager->flush();
            return true;
        } catch (ORMException $e) {
            $this->logger->critical($e->getMessage(), $e);
            return false;
        }
    }

    /**
     * @param EntityInterface $entity
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(EntityInterface $entity){
        $entityManager = $this->getEntityManager();
        $entityManager->remove($entity);
        $entityManager->flush();
    }
}
