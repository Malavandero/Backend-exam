<?php

namespace App\Tests\Domain\Company;
use App\Domain\Company\Company;
use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    public function testShouldCheckDefaultValues(): void
    {
        $company = Company::create('testName');
        $this->assertEquals('testName', $company->getName());
    }

    /**
     *
     */
    public function testShouldCheckCanNameBelongToIsTrue(): void
    {
        $company = Company::create('CompanyTest');
        $result = $company->canNameBelongTo('TestName');
        $this->assertTrue($result, 'Should Can Name Belong To Company');
    }

    /**
     *
     */
    public function testShouldCheckCanNameBelongToIsFalse(): void
    {
        $company = Company::create('ACompanyTste');
        $result = $company->canNameBelongTo('TestName');
        $this->assertFalse($result, 'Should Can Not Name Belong To Company');
    }
}