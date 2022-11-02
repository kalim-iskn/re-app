<?php

namespace App\Contract\Entity\Service;

use App\DTO\EmployeesFileLineDTO;
use EmployeeDTO;

interface EmployeeService
{
    /**
     * @param EmployeesFileLineDTO[] $employeesFileLines
     * @return void
     */
    public function storeByNames(array $employeesFileLines): void;
}
