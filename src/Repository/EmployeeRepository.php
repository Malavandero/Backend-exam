<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     *
     * @param \App\Entity\Employee $entity
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function save(Employee $entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * Soft delete by registry table.
     * @param \App\Entity\Employee $entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Employee $entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
