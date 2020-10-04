<?php

namespace App\Tests\Application\Company\Create;

use App\Application\Company\Create\CreateUseCase;
use App\Tests\Application\CompanyEmployeeTestCase;

class CreateUseCaseTest extends CompanyEmployeeTestCase
{
    protected const COMPANY_TEST_NAME= 'TestName';
    /** @var CreateUseCase  */
    protected $useCase;

    /**
     *
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->useCase = new CreateUseCase(
            $this->getCompanyRepository()
        );
    }

    public function testShouldCreateCompany(): void
    {
        $company = $this->useCase->__invoke(self::COMPANY_TEST_NAME);
        $this->assertEquals(self::COMPANY_TEST_NAME, $company->getName());
    }

}