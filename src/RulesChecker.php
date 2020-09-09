<?php

namespace App;

use App\Entity\Company;
use App\Entity\Employee;

class RulesChecker
{
    public static function isCompatibleCompanyWithEmployee(Company $company, Employee $employee)
    {
        if (strtolower($company->getName())[0] == 'a') {
            if (strtolower($employee->getName())[0] == 'a') {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
}
