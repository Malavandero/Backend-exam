<?php

namespace App\Domain\Company;

class Company
{
    /** @var string|null */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * @param string $name
     * @return self
     */
    public static function create(string $name):self
    {
        $company = new self();
        $company->name = $name;
        return $company;
    }

    /**
     * @return string|null
     */
    public function getId():?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function canNameBelongTo(string $name): bool {
        $companyFirstLetter = substr($this->name, 0, 1);
        $nameFirstLetter= substr($name, 0, 1);
        if ($companyFirstLetter !== 'A') {
            return true;
        }
        return ($nameFirstLetter === 'A');
    }


}