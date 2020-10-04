<?php

namespace App\Tests\Domain\Employee;

use App\Domain\Company\Company;
use App\Domain\Company\EmployeeCanNotBelongToCompany;
use App\Domain\Employee\Employee;
use DateTime;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    protected const EMPLOYEE_TEST_NAME = 'EmployeeName';
    protected const COMPANY_TEST_NAME = 'CompanyTest';
    protected const A_COMPANY_TEST_NAME = 'ACompanyTest';

    public function testShouldCheckCreateEmployee(): void
    {
        $company = Company::create(self::COMPANY_TEST_NAME);
        $employee = Employee::create(self::EMPLOYEE_TEST_NAME, new DateTime('now'), $company);
        $this->assertEquals(self::EMPLOYEE_TEST_NAME, $employee->getName(), 'Should Same Name as Created');
    }

    public function testShouldThrowExcepctionIfEmployeeCanNotBelongToCompany():void
    {
        $company = Company::create(self::A_COMPANY_TEST_NAME);
        $this->expectException(EmployeeCanNotBelongToCompany::class);
        $employee = Employee::create(self::EMPLOYEE_TEST_NAME, new DateTime('now'), $company);
    }
}