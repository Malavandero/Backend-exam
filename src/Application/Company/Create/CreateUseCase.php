<?php

namespace App\Application\Company\Create;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepository;

class CreateUseCase
{
    /** @var CompanyRepository  */
    protected $repository;

    public function __construct(
        CompanyRepository $repository
    )
    {
        $this->repository = $repository;
    }

    /**
     * @param string $name
     * @return Company
     */
    public function __invoke(string $name): Company
    {
        $company = Company::create($name);
        $this->repository->save($company);
        return $company;
    }
}