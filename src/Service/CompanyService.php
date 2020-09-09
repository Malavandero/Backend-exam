<?php

namespace App\Service;


use App\Entity\Company;
use App\Exception\EmployeeNotCompatibleWithCompanyException;
use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;
use App\RulesChecker;
use Assert\Assertion;

class CompanyService extends BaseService
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    private $employeeRepository;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $companyRepository
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(CompanyRepository $companyRepository, EmployeeRepository $employeeRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $name
     * @return \App\Entity\EntityInterface
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function createCompany(string $name)
    {
        Assertion::notEmpty($name, '"name" parameter is mandatory.');
        $company = new Company($name);
        return $this->save($this->companyRepository, $company);
    }

    /**
     * @param string $employeeId
     * @param string $companyId
     * @return \App\Entity\EntityInterface
     * @throws EmployeeNotCompatibleWithCompanyException
     * @throws \Assert\AssertionFailedException
     * @throws \Exception
     */
    public function addEmployeeToCompany(string $employeeId, string $companyId)
    {
        $employee = $this->employeeRepository->find($employeeId);
        $company = $this->companyRepository->find($companyId);

        Assertion::notNull($company);
        Assertion::notNull($employee);

        if (!RulesChecker::isCompatibleCompanyWithEmployee($company, $employee)) {
            throw new EmployeeNotCompatibleWithCompanyException('Company not compatible with employee');
        }

        $employee->setCompany($company);
        return $this->save($this->employeeRepository, $employee);
    }
}