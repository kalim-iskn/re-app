<?php

namespace App\Repository;

use App\Contract\Entity\Repository\EmployeeRepository;
use App\DTO\Entity\EmployeeDTO;
use App\DTO\Entity\EmployeesPaginationDTO;
use App\Entity\Employee;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

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
        return $this->getEntityBy(['id' => $id])->toDto();
    }

    public function getByName(string $name): EmployeeDTO
    {
        return $this->getEntityBy(['name' => $name])->toDto();
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function fromDtoToEntity(EmployeeDTO $dto): Employee
    {
        $entity = $dto->id === null ? new Employee() : $this->getEntityBy(['id' => $dto->id]);

        $entity->setName($dto->name);

        if ($dto->chief !== null) {
            $entity->setChief($this->fromDtoToEntity($dto->chief));
        }

        return $entity;
    }

    public function paginate(int $offset, ?string $chiefName = null): EmployeesPaginationDTO
    {
        $data = new EmployeesPaginationDTO();

        $alias = "employee";
        $query = $this->createQueryBuilder($alias);

        if ($chiefName !== null) {
            $query->where('employee.chief = :chief')
                ->setParameter('chief', $this->getEntityBy(['name' => $chiefName]));
        }

        $query->orderBy("$alias.id")
            ->setFirstResult($offset)
            ->setMaxResults(self::PAGINATE_LIMIT);

        $paginator = new Paginator($query);

        /** @var Employee $entity */
        foreach ($paginator as $entity) {
            $data->items[] = $entity->toDto();
        }

        $data->count = $paginator->count();

        return $data;
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function getEntityBy(array $params): Employee
    {
        $entity = $this->findOneBy($params);

        if (!($entity instanceof Employee)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}
