<?php

namespace App\Job\Handler;

use App\Contract\EmployeesImportService;
use App\Contract\Entity\Service\EmployeeService;
use App\Contract\Entity\Service\FileUploadService;
use App\DTO\EmployeesFileLineDTO;
use App\Job\EmployeesFileProcessingMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmployeesFileProcessingHandler
{
    protected FileUploadService $fileUploadService;
    protected EmployeeService $employeeService;
    protected ParameterBagInterface $parameterBag;
    protected LoggerInterface $logger;

    public function __construct(
        FileUploadService $fileUploadService,
        EmployeeService $employeeService,
        ParameterBagInterface $parameterBag,
        LoggerInterface $logger
    ) {
        $this->fileUploadService = $fileUploadService;
        $this->employeeService = $employeeService;
        $this->parameterBag = $parameterBag;
        $this->logger = $logger;
    }

    public function __invoke(EmployeesFileProcessingMessage $employeesFileProcessing): void
    {
        $fileUploadInfo = $this->fileUploadService->getById($employeesFileProcessing->getFileUploadId());

        $file = $this->parameterBag->get('kernel.project_dir') . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR .
            EmployeesImportService::EMPLOYEES_FILES_DIRECTORY . DIRECTORY_SEPARATOR . $fileUploadInfo->fileName;

        $handleFile = fopen($file, "r");

        $linesDto = [];
        $limitToSend = 100;

        while (!feof($handleFile)) {
            $line = fgets($handleFile);
            $line = trim($line);

            list($employeeName, $employeeChiefName) = explode(",", $line);

            if (empty($employeeChiefName)) {
                $employeeChiefName = null;
            }

            $lineDto = new EmployeesFileLineDTO();
            $lineDto->employeeName = $employeeName;
            $lineDto->chiefName = $employeeChiefName;

            $linesDto[] = $lineDto;

            if (count($linesDto) == $limitToSend || $lineDto->chiefName === null) {
                $this->employeeService->storeByNames($linesDto);
                $this->fileUploadService->addProcessedLines($fileUploadInfo->id, count($linesDto));
                $linesDto = [];
            }
        }
        #TODO ADD SEND
        fclose($handleFile);
    }
}
