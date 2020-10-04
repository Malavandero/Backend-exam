<?php

namespace App\Tests\Application\Employee\Create;

use App\Application\Employee\Create\CreateUseCase;
use App\Domain\Company\Company;
use App\Domain\Company\CompanyNotExists;
use App\Tests\Application\CompanyEmployeeTestCase;
use DateTime;

class CreateUseCaseTest extends CompanyEmployeeTestCase
{
    protected const COMPANY_TEST_NAME= 'TestName';
    protected const COMPANY_TEST_ID= '0e447fe5-0629-11eb-ac51-0242c0a80003';


    /** @var CreateUseCase  */
    protected $useCase;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new CreateUseCase(
            $this->getEmployeeRepository(),
            $this->getCompanyRepository()
        );
    }

    public function testShouldThrowExceptionIfNotCompany():void
    {
        $this->expectException(CompanyNotExists::class);
        $this->useCase->__invoke('name', new DateTime('now'), self::COMPANY_TEST_ID);
    }
    public function testShouldCreateEmployee():void
    {
        $company = Company::create('CompanyAfter');
        $this->shouldSearchCompany(self::COMPANY_TEST_ID, $company);
        $this->shouldSaveEmployee();
        $employee = $this->useCase->__invoke('name', new DateTime('now'), self::COMPANY_TEST_ID);
        $this->assertEquals($employee->getCompany(), $company, 'Company Should Be Same as Before when change in Employee' );
        $this->assertEquals($employee->getName(), 'name', 'Company Should Be Have Same Name as requested' );

    }

}