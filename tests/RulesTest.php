<?php

namespace App\Tests;


use App\Entity\Company;
use App\Entity\Employee;
use App\RulesChecker;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    /**
     * @test
     */
    public function shouldCheckCompatibilityBetweenCompanyAndEmployee()
    {
        $company = new Company('AAAAAA');
        $employee = new Employee('AAAAAA', \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-12 12:00:00'));
        $this->assertTrue(RulesChecker::isCompatibleCompanyWithEmployee($company, $employee));

        $company = new Company('aAaa');
        $employee = new Employee('aaaaa', \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-12 12:00:00'));
        $this->assertTrue(RulesChecker::isCompatibleCompanyWithEmployee($company, $employee));


        $company = new Company('AAAAAA');
        $employee = new Employee('BAAAAA', \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-12 12:00:00'));
        $this->assertFalse(RulesChecker::isCompatibleCompanyWithEmployee($company, $employee));

        $company = new Company('aaaa');
        $employee = new Employee('bbb', \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-12 12:00:00'));
        $this->assertFalse(RulesChecker::isCompatibleCompanyWithEmployee($company, $employee));

        $company = new Company('eeee');
        $employee = new Employee('bbb', \DateTime::createFromFormat('Y-m-d H:i:s', '2020-12-12 12:00:00'));
        $this->assertTrue(RulesChecker::isCompatibleCompanyWithEmployee($company, $employee));
    }
}