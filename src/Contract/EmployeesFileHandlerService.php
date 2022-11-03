<?php

namespace App\Contract;

use App\Job\EmployeesFileProcessingMessage;

interface EmployeesFileHandlerService
{
    public function handle(EmployeesFileProcessingMessage $employeesFileProcessing): void;
}
