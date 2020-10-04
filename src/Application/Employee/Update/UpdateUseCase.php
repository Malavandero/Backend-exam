<?php

namespace App\Application\Employee\Update;

use App\Domain\Company\CompanyNotExists;
use App\Domain\Company\CompanyRepository;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeNotExists;
use App\Domain\Employee\EmployeeRepository;
use DateTime;

class UpdateUseCase
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
     * @param string $employeeId
     * @param string $name
     * @param DateTime $hiringDate
     * @param string $companyId
     * @return Employee
     */
    public function __invoke(string $employeeId, string $name, DateTime $hiringDate, string $companyId): Employee
    {
        $employee = $this->employeeRepository->search($employeeId);
        if(!$employee) {
            throw new EmployeeNotExists($employeeId);
        }
        $company = $this->companyRepository->search($companyId);
        if(!$company) {
            throw new CompanyNotExists($companyId);
        }

        $employee->change($name, $hiringDate, $company);
        $this->employeeRepository->save($employee);
        return $employee;
    }

}