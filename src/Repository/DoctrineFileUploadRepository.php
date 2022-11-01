<?php

namespace App\Repository;

use App\Contract\Entity\Repository\FileUploadRepository;
use App\Entity\FileUpload;
use App\Exception\EntityNotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use FileUploadInfoDTO;

class DoctrineFileUploadRepository extends ServiceEntityRepository implements FileUploadRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileUpload::class);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function getById(int $id): FileUploadInfoDTO
    {
        return $this->getEntity($id)->toDto();
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function fromDtoToEntity(FileUploadInfoDTO $dto): FileUpload
    {
        $entity = $dto->id === null ? new FileUpload() : $this->getEntity($dto->id);;

        $entity->setFileName($dto->fileName);
        if ($dto->createdAt !== null) {
            $entity->setCreatedAt($dto->createdAt);
        }
        $entity->setLinesCount($dto->linesCount);
        $entity->setProcessedLinesCount($dto->processedLinesCount);

        return $entity;
    }

    public function save(FileUploadInfoDTO $dto): FileUploadInfoDTO
    {
        $entity = $this->fromDtoToEntity($dto);

        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity->toDto();
    }

    /**
     * @throws EntityNotFoundException
     */
    protected function getEntity(int $id): FileUpload
    {
        $entity = $this->find($id);

        if (!($entity instanceof FileUpload)) {
            throw new EntityNotFoundException();
        }

        return $entity;
    }
}
