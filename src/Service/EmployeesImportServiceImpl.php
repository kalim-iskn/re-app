<?php

namespace App\Service;

use App\Contract\EmployeesImportService;
use App\Contract\Entity\Service\FileUploadService as FileUploadEntityService;
use App\Contract\FileUploadService;
use App\Job\EmployeesFileProcessingMessage;
use FileUploadInfoDTO;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\MessageBusInterface;

class EmployeesImportServiceImpl implements EmployeesImportService
{
    protected FileUploadService $fileUploadService;
    protected FileUploadEntityService $fileUploadEntityService;
    protected MessageBusInterface $messageBus;

    public function __construct(
        FileUploadService $fileUploadService,
        FileUploadEntityService $fileUploadEntityService,
        MessageBusInterface $messageBus
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->fileUploadEntityService = $fileUploadEntityService;
        $this->messageBus = $messageBus;
    }

    public function import(UploadedFile $file): void
    {
        $fileName = $this->fileUploadService->upload($file, self::EMPLOYEES_FILES_DIRECTORY);

        $dto = new FileUploadInfoDTO();
        $dto->fileName = $fileName;
        $dto->linesCount = $this->getLinesCount($fileName);
        $dto = $this->fileUploadEntityService->store($dto);

        $this->messageBus->dispatch(new EmployeesFileProcessingMessage($dto->id));
    }

    protected function getLinesCount(string $fileName): int
    {
        $file = self::EMPLOYEES_FILES_DIRECTORY . DIRECTORY_SEPARATOR . $fileName;
        $linesCount = 0;
        $handleFile = fopen($file, "r");

        while (!feof($handleFile)) {
            fgets($handleFile);
            $linesCount++;
        }

        fclose($handleFile);

        return $linesCount;
    }
}
