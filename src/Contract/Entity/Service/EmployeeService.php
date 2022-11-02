<?php

namespace App\Contract\Entity\Service;

use App\DTO\EmployeesFileLineDTO;
use App\DTO\Entity\EmployeesPaginationDTO;

interface EmployeeService
{
    /**
     * @param EmployeesFileLineDTO[] $employeesFileLines
     * @return void
     */
    public function storeByNames(array $employeesFileLines): void;

    public function get(int $page, ?string $chiefName = null): EmployeesPaginationDTO;
}
