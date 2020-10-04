<?php


namespace App\Tests\Application\Employee\Delete;


use App\Application\Employee\Delete\DeleteUseCase;
use App\Domain\Company\Company;
use App\Domain\Employee\Employee;
use App\Domain\Employee\EmployeeNotExists;
use App\Tests\Application\CompanyEmployeeTestCase;
use DateTime;

class DeleteUseCaseTest extends CompanyEmployeeTestCase
{
    protected const EMPLOYEE_TEST_ID= '8b54f3cb-0654-11eb-ac51-0242c0a80003';

    /** @var DeleteUseCase  */
    protected $useCase;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new DeleteUseCase(
            $this->getEmployeeRepository()
        );
    }

    /**
     *
     */
    protected function shouldRemoveEmployee(): void
    {
        $this->getEmployeeRepository()
            ->expects($this->once())
            ->method('remove')
            ->with($this->isInstanceOf(Employee::class))
            ->willReturn(null);
    }

    public function testShouldThrowExceptionIfNotEmployee():void
    {
        $this->expectException(EmployeeNotExists::class);
        $this->useCase->__invoke(self::EMPLOYEE_TEST_ID);
    }

    public function testShouldRemoveEmployee(): void
    {
        $companyAfter = Company::create('CompanyAfter');
        $employee = Employee::create('TestName', new DateTime('now'), $companyAfter);
        $this->shouldSearchEmployee(self::EMPLOYEE_TEST_ID, $employee);
        $this->shouldRemoveEmployee();
        $this->useCase->__invoke(self::EMPLOYEE_TEST_ID);
    }

}