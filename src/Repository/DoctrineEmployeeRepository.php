<?php

namespace App\Repository;

use App\Contract\Entity\Repository\EmployeeRepository;
use App\Entity\Employee;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use EmployeeDTO;

class DoctrineEmployeeRepository extends ServiceEntityRepository implements EmployeeRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function save(EmployeeDTO $dto): EmployeeDTO
    {
        $entity = $this->fromDtoToEntity($dto);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity->toDto();
    }

    public function saveMany(array $arDto): void
    {
        foreach ($arDto as $dto) {
            $entity = $this->fromDtoToEntity($dto);
            $this->_em->persist($entity);
        }

        $this->_em->flush();
        $this->_em->clear();
    }

    public function getById(int $id): EmployeeDTO
    {
        return $this->getEntity($id)->toDto();
    }

    public function getByName(string $name): EmployeeDTO
    {
        $entity = $this->findOneBy(['name' => $name]);

        if (!($entity instanceof Employee)) {
            throw new EntityNotFoundException();
        }

        return $entity->toDto();
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function fromDtoToEntity(EmployeeDTO $dto): Employee
    {
        $entity = $dto->id === null ? new Employee() : $this->getEntity($dto->id);;

        $entity->setName($dto->name);

        if ($dto->chief !== null) {
            $entity->setChief($this->fromDtoToEntity($dto->chief));
        }

        return $entity;
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function getEntity(int $id): Employee
    {
        $entity = $this->find($id);

        if (!($entity instanceof Employee)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}
