<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CompanyRepositoryMysql
    extends ServiceEntityRepository
    implements CompanyRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    /**
     * @param Company $company
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Company $company): void
    {
        $this->_em->persist($company);
        $this->_em->flush();
    }

    /**
     * @param string $companyId
     * @return Company|null
     */
    public function search(string $companyId): ?Company
    {
        return $this->findOneBy(['id' => $companyId]);
    }


}


