<?php

namespace App\Domain\Company;

use DomainException;

class EmployeeCanNotBelongToCompany extends DomainException
{
    /** @var string  */
    protected $employeeName;
    /** @var string */
    protected $companyName;

    /**
     * @param string $employeeName
     */
    public function __construct(string $employeeName, string $companyname)
    {
        $this->employeeName = $employeeName;
        $this->companyName = $companyname;
        parent::__construct($this->errorMsg());
    }

    /**
     * @return string
     */
    protected function errorMsg(): string
    {
        return sprintf('The employee <%s> can not belong to company <%s>', $this->employeeName, $this->companyName);
    }
}