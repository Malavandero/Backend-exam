<?php

namespace App\Domain\Company;

use DomainException;

class CompanyNotExists extends DomainException
{
    /** @var string  */
    protected $companyId;

    /**
     * CompanyNotExists constructor.
     * @param string $companyId
     */
    public function __construct(string $companyId)
    {
        $this->companyId = $companyId;
        parent::__construct($this->errorMsg());
    }

    /**
     * @return string
     */
    protected function errorMsg(): string
    {
        return sprintf('The company <%s> does not exist', $this->companyId);
    }
}