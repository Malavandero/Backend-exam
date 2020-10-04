<?php

namespace App\Application\Employee\Create;

use App\Domain\Company\CompanyNotExists;
use App\Domain\Company\CompanyRepository;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeRepository;
use DateTime;

class CreateUseCase
{
    /** @var EmployeeRepository  */
    protected $employeeRepository;
    /** @var CompanyRepository  */
    protected $companyRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        CompanyRepository $companyRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param string $name
     * @param DateTime $hiringDate
     * @param string $companyId
     * @return Employee
     */
    public function __invoke(string $name, DateTime $hiringDate, string $companyId): Employee
    {
        $company = $this->companyRepository->search($companyId);
        if(!$company) {
            throw new CompanyNotExists($companyId);
        }
        $employee = Employee::create($name, $hiringDate, $company);
        $this->employeeRepository->save($employee);
        return $employee;
    }

}