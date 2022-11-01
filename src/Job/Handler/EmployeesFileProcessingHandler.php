<?php

namespace App\Job\Handler;

use App\Contract\Entity\FileUploadService;
use App\Job\EmployeesFileProcessingMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmployeesFileProcessingHandler
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function __invoke(EmployeesFileProcessingMessage $employeesFileProcessing): void
    {
        $fileUploadInfo = $this->fileUploadService->getById($employeesFileProcessing->getFileUploadId());

        foreach (range($fileUploadInfo->processedLinesCount, $fileUploadInfo->linesCount - 1) as $lineNumber) {
            $this->fileUploadService->addProcessedLine($fileUploadInfo->id);
        }
    }
}
