<?php

namespace App\Util;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Employee;

class EmployeeService{

    private $employeeRepository;
    private $em;
    private $serializer;

    public function __construct(EmployeeRepository $employeeRepository, EntityManagerInterface $em, SerializerInterface $serializer){
        $this->employeeRepository = $employeeRepository;
        $this->em = $em;
        $this->serializer = $serializer;

    }

    public function create($data)
    {
        return $this->save(new Employee(), $data);

    }

    public function modify($id, $data)
    {
        $employee = $this->employeeRepository->find($id);

        if(!$employee instanceof Employee){
            throw new \Exception("Employee does not exists", 1);
            
        }

        return $this->save($employee, $data);
    }

    public function delete($id)
    {
        $employee = $this->employeeRepository->find($id);
        if(!$employee instanceof Employee){
            throw new \Exception("Employee does not exists", 1);
            
        }
        $this->em->remove($employee);
        $this->em->flush();
    }
    

    public function getAll()
    {
        return $this->employeeRepository->findAll();
    }

    private function save($employee, $data)
    {
        $this->serializer->deserialize($data, Employee::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $employee]);

        $this->checkCompanyName($employee);

        $this->em->persist($employee);
        $this->em->flush();
        $this->em->refresh($employee);
        return $employee;
    }

    private function checkCompanyName(Employee $employee)
    {
        $firstLetterEmployee = strtolower(substr($employee->getName(), 0, 1));
        $firstLetterCompany = strtolower(substr($employee->getCompany()->getName(), 0, 1));

        if($firstLetterCompany === 'a' && $firstLetterEmployee !=='a'){
            throw new \Exception("Employee name does not comply with company name", 1);
        }

        return true;

    }

}

