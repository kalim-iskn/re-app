<?php

namespace App\DTO\Entity;

use App\Contract\Entity\Repository\EmployeeRepository;

class EmployeesPaginationDTO
{
    /**
     * @var EmployeeDTO[] $items
     */
    public array $items = [];

    public int $limit = EmployeeRepository::PAGINATE_LIMIT;

    public int $count = 0;
}
