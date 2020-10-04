<?php

namespace App\Application\Company\AddEmployee;

use App\Domain\Company\CompanyNotExists;
use App\Domain\Company\CompanyRepository;
use App\Domain\Employee\EmployeeNotExists;
use App\Domain\Employee\EmployeeRepository;

class AddEmployeeUseCase
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
     * @param string $companyId
     * @param string $employeeId
     */
    public function __invoke(string $companyId, string $employeeId): void
    {
        $employee = $this->employeeRepository->search($employeeId);
        if(!$employee) {
            throw new EmployeeNotExists($employeeId);
        }
        $company = $this->companyRepository->search($companyId);
        if(!$company) {
            throw new CompanyNotExists($companyId);
        }
        $employee->changeCompany($company);
        $this->employeeRepository->save($employee);

    }
}