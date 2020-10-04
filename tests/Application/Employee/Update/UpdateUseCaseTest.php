<?php

namespace App\Tests\Application\Employee\Update;

use App\Application\Employee\Update\UpdateUseCase;
use App\Domain\Company\Company;
use App\Domain\Company\CompanyNotExists;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeNotExists;
use App\Tests\Application\CompanyEmployeeTestCase;
use DateTime;

class UpdateUseCaseTest extends CompanyEmployeeTestCase
{
    protected const COMPANY_TEST_NAME= 'TestName';
    protected const COMPANY_TEST_ID= '0e447fe5-0629-11eb-ac51-0242c0a80003';
    protected const EMPLOYEE_TEST_ID= '8b54f3cb-0654-11eb-ac51-0242c0a80003';

    /** @var UpdateUseCase  */
    protected $useCase;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new UpdateUseCase(
            $this->getEmployeeRepository(),
            $this->getCompanyRepository()
        );
    }

    public function testShouldThrowExceptionIfNotEmployee():void
    {
        $this->expectException(EmployeeNotExists::class);
        $this->useCase->__invoke(self::EMPLOYEE_TEST_ID, 'newName', new DateTime('now'), self::COMPANY_TEST_ID);
    }

    public function testShouldThrowExceptionIfNotCompany():void
    {
        $companyAfter = Company::create('CompanyAfter');
        $employee = Employee::create('TestName', new DateTime('now'), $companyAfter);
        $this->shouldSearchEmployee(self::EMPLOYEE_TEST_ID, $employee);
        $this->expectException(CompanyNotExists::class);
        $this->useCase->__invoke(self::EMPLOYEE_TEST_ID, 'newName', new DateTime('now'), self::COMPANY_TEST_ID);
    }

    public function testShouldUpdateEmployeeData():void
    {
        $companyAfter = Company::create('CompanyAfter');
        $companyBefore = Company::create('CompanyBefore');
        $employee = Employee::create('TestName', new DateTime('now'), $companyAfter);
        $this->shouldSearchEmployee(self::EMPLOYEE_TEST_ID, $employee);
        $this->shouldSearchCompany(self::COMPANY_TEST_ID, $companyBefore);
        $this->useCase->__invoke(self::EMPLOYEE_TEST_ID, 'newName', new DateTime('now'), self::COMPANY_TEST_ID);
        $this->assertEquals($employee->getCompany(), $companyBefore, 'Company Should Be Same as Before when change in Employee' );
        $this->assertEquals($employee->getName(), 'newName', 'Name should same as requested' );

    }

}