<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class EmployeeRepositoryMySql
    extends ServiceEntityRepository
    implements EmployeeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param Employee $employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Employee $employee): void
    {
        $this->_em->persist($employee);
        $this->_em->flush();
    }

    /**
     * @param string $employeeId
     * @return Employee|null
     */
    public function search(string $employeeId): ?Employee
    {
        return $this->findOneBy(['id' => $employeeId]);
    }

    /**
     * @param Employee $employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Employee $employee): void
    {
        $this->_em->remove($employee);
        $this->_em->flush();
    }


}


