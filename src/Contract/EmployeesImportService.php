<?php

namespace App\Contract;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface EmployeesImportService
{
    final public const EMPLOYEES_FILES_DIRECTORY = 'uploads/employees';

    public function import(UploadedFile $file): int;
}
