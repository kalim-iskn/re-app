<?php

namespace App\DTO\Entity;

class EmployeeDTO
{
    public ?int $id = null;

    public string $name;

    public ?EmployeeDTO $chief = null;
}
