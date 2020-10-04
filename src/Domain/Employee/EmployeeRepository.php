<?php

namespace App\Domain\Employee;

interface EmployeeRepository
{
    public function save(Employee $employee): void;
    public function remove(Employee $employee): void;
    public function search(string $employeeId): ?Employee;
}