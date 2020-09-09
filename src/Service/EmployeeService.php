<?php

namespace App\Service;

use App\Entity\Employee;
use App\Exception\EmployeeNotExistException;
use App\Repository\EmployeeRepository;

class EmployeeService extends BaseService
{

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * EmployeeService constructor.
     */
    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $name
     * @param \DateTime $hiringDate
     * @return \App\Entity\EntityInterface
     * @throws \Exception
     */
    public function createEmployee(string $name, \DateTime $hiringDate)
    {
        $employee = new Employee($name, $hiringDate);
        return $this->save($this->employeeRepository, $employee);
    }

    /**
     * @param string $id
     * @param string $name
     * @param \DateTime $hiringDate
     * @return \App\Entity\EntityInterface
     * @throws EmployeeNotExistException
     * @throws \Exception
     */
    public function updateEmployee(string $id, string $name, \DateTime $hiringDate)
    {
        $employee = $this->employeeRepository->find($id);
        if (isset($employee)) {
            $employee->setHiringDate(new \DateTime('Y-d-m H:i:s', $hiringDate));
            $employee->setName($name);
            return $this->save($this->employeeRepository, $employee);
        }
        throw new EmployeeNotExistException('Employee not founded by this ID');
    }

    /**
     * @param string $id
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws EmployeeNotExistException
     */
    public function removeEmployee(string $id){
        $employee = $this->employeeRepository->find($id);
        if (isset($employee)) {
            $this->employeeRepository->remove($employee);
        }
        throw new EmployeeNotExistException('Employee not founded by this ID');
    }
}
