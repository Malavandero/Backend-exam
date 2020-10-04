<?php

namespace App\Application\Employee\Delete;

use App\Domain\Employee\EmployeeNotExists;
use App\Domain\Employee\EmployeeRepository;

class DeleteUseCase
{
    /** @var EmployeeRepository  */
    protected $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $employeeId
     */
    public function __invoke(string $employeeId): void
    {
        $employee = $this->repository->search($employeeId);
        if(!$employee) {
            throw new EmployeeNotExists($employeeId);
        }
        $this->repository->remove($employee);
    }

}