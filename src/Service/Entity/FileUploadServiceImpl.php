<?php

namespace App\Service\Entity;

use App\Contract\Entity\Service\FileUploadService;
use App\Contract\Entity\Repository\FileUploadRepository;
use FileUploadInfoDTO;

class FileUploadServiceImpl implements FileUploadService
{
    protected FileUploadRepository $fileUploadRepository;

    public function __construct(FileUploadRepository $fileUploadRepository)
    {
        $this->fileUploadRepository = $fileUploadRepository;
    }

    public function store(FileUploadInfoDTO $dto): FileUploadInfoDTO
    {
        return $this->fileUploadRepository->save($dto);
    }

    public function getById(int $id): FileUploadInfoDTO
    {
        return $this->fileUploadRepository->getById($id);
    }

    public function addProcessedLines(int $id, int $count): void
    {
        $dto = $this->getById($id);

        $dto->processedLinesCount += $count;

        $this->fileUploadRepository->save($dto);
    }
}
