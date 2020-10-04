<?php

namespace App\Tests\Application\Company\AddEmployee;

use App\Application\Company\AddEmployee\AddEmployeeUseCase;
use App\Domain\Company\Company;
use App\Domain\Company\CompanyNotExists;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeNotExists;
use App\Tests\Application\CompanyEmployeeTestCase;
use DateTime;

class AddEmployeeUseCaseTest extends CompanyEmployeeTestCase
{
    protected const COMPANY_TEST_NAME= 'TestName';
    protected const COMPANY_TEST_ID= '0e447fe5-0629-11eb-ac51-0242c0a80003';
    protected const EMPLOYEE_TEST_ID= '8b54f3cb-0654-11eb-ac51-0242c0a80003';

    /** @var AddEmployeeUseCase  */
    protected $useCase;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new AddEmployeeUseCase(
            $this->getEmployeeRepository(),
            $this->getCompanyRepository()
        );
    }

    public function testShouldThrowExceptionIfNotEmployee():void
    {
        $this->expectException(EmployeeNotExists::class);
        $this->useCase->__invoke(self::COMPANY_TEST_ID, self::EMPLOYEE_TEST_ID);
    }

    public function testShouldThrowExceptionIfNotCompany():void
    {
        $companyAfter = Company::create('CompanyAfter');
        $employee = Employee::create('TestName', new DateTime('now'), $companyAfter);
        $this->shouldSearchEmployee(self::EMPLOYEE_TEST_ID, $employee);
        $this->expectException(CompanyNotExists::class);
        $this->useCase->__invoke(self::COMPANY_TEST_ID, self::EMPLOYEE_TEST_ID);
    }

    public function testShouldChangeCompanyToEmployee():void
    {
        $companyAfter = Company::create('CompanyAfter');
        $companyBefore = Company::create('CompanyBefore');
        $employee = Employee::create('TestName', new DateTime('now'), $companyAfter);
        $this->shouldSearchEmployee(self::EMPLOYEE_TEST_ID, $employee);
        $this->shouldSearchCompany(self::COMPANY_TEST_ID, $companyBefore);
        $this->useCase->__invoke(self::COMPANY_TEST_ID, self::EMPLOYEE_TEST_ID);
        $this->assertEquals($employee->getCompany(), $companyBefore, 'Company Should Be Same as Before when change in Employee' );

    }

}