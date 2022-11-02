<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\DTO\Entity\EmployeeDTO;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Employee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee")
     * @ORM\JoinColumn(fieldName="id", nullable=true)
     */
    protected ?Employee $chief = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Employee|null
     */
    public function getChief(): ?Employee
    {
        return $this->chief;
    }

    /**
     * @param Employee|null $chief
     */
    public function setChief(?Employee $chief): void
    {
        $this->chief = $chief;
    }

    public function toDto(): EmployeeDTO
    {
        $dto = new EmployeeDTO();

        $dto->id = $this->id;
        $dto->name = $this->name;

        if ($this->chief !== null) {
            $dto->chief = new EmployeeDTO();
            $dto->chief->id = $this->chief->getId();
            $dto->chief->name = $this->chief->getName();
        }

        return $dto;
    }
}
