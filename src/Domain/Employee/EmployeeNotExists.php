<?php

namespace App\Domain\Employee;

use DomainException;

class EmployeeNotExists extends DomainException
{
    /** @var string */
    protected $employeeId;

    /**
     *
     * @param string $employeeId
     */
    public function __construct(string $employeeId)
    {
        $this->employeeId = $employeeId;
        parent::__construct($this->errorMsg());
    }

    /**
     * @return string
     */
    protected function errorMsg(): string
    {
        return sprintf('The employee <%s> does not exist', $this->employeeId);
    }
}