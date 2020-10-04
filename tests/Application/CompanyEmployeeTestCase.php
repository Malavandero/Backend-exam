<?php

namespace App\Tests\Application;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepository;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class CompanyEmployeeTestCase extends TestCase
{
    protected $employeeRepository;
    protected $companyRepository;

    /**
     * @return EmployeeRepository|MockObject
     */
    protected function getEmployeeRepository()
    {
        return $this->employeeRepository = $this->employeeRepository ?: $this->createMock(EmployeeRepository::class);
    }

    /**
     * @return CompanyRepository|MockObject
     */
    protected function getCompanyRepository()
    {
        return $this->companyRepository = $this->companyRepository ?: $this->createMock(CompanyRepository::class);
    }

    /**
     * @param string $id
     * @param Company|null $company
     */
    protected function shouldSearchCompany(string $id, Company $company=null): void
    {
        $this->getCompanyRepository()
            ->expects($this->once())
            ->method('search')
            ->with($this->equalTo($id))
            ->willReturn($company);
    }

    /**
     * @param string $id
     * @param Employee|null $employee
     */
    protected function shouldSearchEmployee(string $id, Employee $employee=null): void
    {
        $this->getEmployeeRepository()
            ->expects($this->once())
            ->method('search')
            ->with($this->equalTo($id))
            ->willReturn($employee);
    }

    /**
     *
     */
    protected function shouldSaveEmployee(): void
    {
        $this->getEmployeeRepository()
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(Employee::class))
            ->willReturn(null);
    }

}