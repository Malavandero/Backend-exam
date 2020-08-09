<?php

namespace App\Util;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Company;

class CompanyService{

    private $companyRepository;
    private $em;
    private $serializer;

    public function __construct(CompanyRepository $companyRepository, EntityManagerInterface $em, SerializerInterface $serializer){
        $this->companyRepository = $companyRepository;
        $this->em = $em;
        $this->serializer = $serializer;

    }

    public function create($data)
    {
        return $this->save(new Company(), $data);
    }
    private function save($company, $data)
    {
        $company = $this->serializer->deserialize($data, Company::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $company]);
        $this->em->persist($company);
        $this->em->flush();
        $this->em->refresh($company);
        return $company;
    }

    public function getAll()
    {
        return $this->companyRepository->findAll();
    }

}

