<?php

namespace App\Contract\Entity\Repository;

use App\DTO\Entity\EmployeesPaginationDTO;
use App\Exception\EntityNotFoundException;
use App\DTO\Entity\EmployeeDTO;

interface EmployeeRepository
{
    const PAGINATE_LIMIT = 25;

    /**
     * @throws EntityNotFoundException
     */
    public function save(EmployeeDTO $dto): EmployeeDTO;

    /**
     * @param EmployeeDTO[] $arDto
     * @throws EntityNotFoundException
     */
    public function saveMany(array $arDto): void;

    /**
     * @throws EntityNotFoundException
     */
    public function getById(int $id): EmployeeDTO;

    /**
     * @throws EntityNotFoundException
     */
    public function getByName(string $name): EmployeeDTO;

    public function paginate(int $offset, ?string $chiefName = null): EmployeesPaginationDTO;
}
