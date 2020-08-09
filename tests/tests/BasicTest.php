<?php

namespace App\Tests;

use App\Util\CompanyService;
use App\Util\EmployeeService;
use App\Entity\Company;
use App\Entity\Employee;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BasicTest extends KernelTestCase
{
    private $employeeService;
    private $companyService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->employeeService =  self::$container->get('App\Util\EmployeeService');
        $this->companyService =  self::$container->get('App\Util\CompanyService');
    }
    
    public function testCreateEmployeeCase1()
    {
        $company = $this->companyService->create(json_encode(['name' => 'a company']));
        $this->assertTrue($company instanceof Company);
        $employee = $this->employeeService->create(json_encode(['name' => 'an employee', 'hireDate' => '2020-05-10', 'company' => $company->getId()]));
        $this->assertTrue($employee instanceof Employee);
    }
    public function testCreateEmployeeCase2()
    {
        $this->expectException(\Exception::class);
        
        $company = $this->companyService->create(json_encode(['name' => 'a company']));
        $this->assertTrue($company instanceof Company);

        $employee = $this->employeeService->create(json_encode(['name' => 'employee', 'hireDate' => '2020-05-10', 'company' => $company->getId()]));
       
    }
    public function testCreateEmployeeCase3()
    {
        $company = $this->companyService->create(json_encode(['name' => 'company']));
        $this->assertTrue($company instanceof Company);

        $employee = $this->employeeService->create(json_encode(['name' => 'employee', 'hireDate' => '2020-05-10', 'company' => $company->getId()]));
        $this->assertTrue($employee instanceof Employee);
    }
    public function testCreateEmployeeCase4()
    {
        $company = $this->companyService->create(json_encode(['name' => 'company']));
        $this->assertTrue($company instanceof Company);

        $employee = $this->employeeService->create(json_encode(['name' => 'an employee', 'hireDate' => '2020-05-10', 'company' => $company->getId()]));
        $this->assertTrue($employee instanceof Employee);

    }
}
