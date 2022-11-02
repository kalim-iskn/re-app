<?php

namespace App\Contract\Entity\Repository;

use App\Exception\EntityNotFoundException;
use EmployeeDTO;

interface EmployeeRepository
{
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
}
