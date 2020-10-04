<?php

namespace App\Domain\Company;

interface CompanyRepository
{
    public function save(Company $company): void;

    public function search(string $companyId): ?Company;

}