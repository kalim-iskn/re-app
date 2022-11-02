<?php

namespace App\Job\Handler;

use App\Job\EmployeesFileProcessingMessage;
use App\Service\EmployeesFileHandlerService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmployeesFileProcessingHandler
{
    protected EmployeesFileHandlerService $employeesFileHandlerService;

    public function __construct(EmployeesFileHandlerService $employeesFileHandlerService)
    {
        $this->employeesFileHandlerService = $employeesFileHandlerService;
    }

    public function __invoke(EmployeesFileProcessingMessage $employeesFileProcessing): void
    {
        $this->employeesFileHandlerService->handle($employeesFileProcessing);
    }
}
