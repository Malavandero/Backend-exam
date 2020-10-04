<?php

namespace App\Domain\Employee;

use App\Domain\Company\Company;
use App\Domain\Company\EmployeeCanNotBelongToCompany;
use DateTime;

class Employee
{
    /** @var string|null */
    protected $id;

    /** @var string */
    protected $name;

    /** @var DateTime */
    protected $hiringDate;

    /** @var Company */
    protected $company;

    /**
     * @param string $name
     * @param DateTime $hiringDate
     * @param Company $company
     * @return self
     */
    public static function create(string $name, DateTime $hiringDate, Company $company): self
    {
        $employee = new self();
        $employee->change($name, $hiringDate, $company);
        return $employee;
    }


    /**
     * @param string $name
     * @param DateTime $hiringDate
     * @param Company $company
     */
    public function change(string $name, DateTime $hiringDate, Company $company): void
    {
        $this->name = $name;
        $this->hiringDate = $hiringDate;
        $this->changeCompany($company);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @return DateTime
     */
    public function getHiringDate(): DateTime
    {
        return $this->hiringDate;
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return $this->company->getId();
    }

    public function getCompany():Company
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function changeCompany(Company $company): void
    {
        if (!$company->canNameBelongTo($this->name)){
            throw new EmployeeCanNotBelongToCompany($this->name, $company->getName());
        }
        $this->company = $company;
    }

}




