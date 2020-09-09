<?php

namespace App\Service;

use App\Entity\Company;
use App\Entity\Employee;
use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class EmployeeService
{
    /** @var EmployeeRepository $itemRepository */
    private $itemRepository;

    /** @var CompanyRepository $companyRepository */
    private $companyRepository;

    public function __construct(
        EmployeeRepository $itemRepository,
        CompanyRepository $companyRepository
    )
    {
        $this->itemRepository = $itemRepository;
        $this->companyRepository = $companyRepository;
    }

    public function create($employeeName, $contractDate)
    {
        $item = new Employee();
        $item->setName($employeeName);
        $item->setContractDate(new \DateTime($contractDate));

        try {
            $this->itemRepository->save($item);
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $item;
    }

    public function addCompany($employeeId, $companyId)
    {
        /** @var Employee $item */
        $employee = $this->itemRepository->find($employeeId);
        if (!$employee) {
            throw new ResourceNotFoundException("Employee not found");
        }

        /** @var Company $item */
        $company = $this->companyRepository->find($companyId);
        if (!$company) {
            throw new ResourceNotFoundException("Company not found");
        }

        $companyName = substr(strtolower($company->getName()), 0, 1);
        $employeeName = substr(strtolower($employee->getName()), 0, 1);

        if ($companyName == 'a'){
            if ($employeeName != 'a') {
                throw new \Exception("The company can only have employees with names starting in a");
            }
        }

        $employee->setCompany($company);

        try {
            $this->itemRepository->save($employee);
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $employee;
    }

    public function update($employeeId, $employeeName, $contractDate)
    {
        /** @var Employee $item */
        $employee = $this->itemRepository->find($employeeId);
        if (!$employee) {
            throw new ResourceNotFoundException("Employee not found");
        }

        $employee->setName($employeeName);
        $employee->setContractDate(new \DateTime($contractDate));

        try {
            $this->itemRepository->save($employee);
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $employee;
    }

    public function delete($employeeId)
    {
        /** @var Employee $employee */
        $employee = $this->itemRepository->find($employeeId);
        if (!$employee) {
            throw new ResourceNotFoundException("Employee not found");
        }

        try {
            $this->itemRepository->delete($employee);
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        return "Employee deleted successfully";
    }
}