<?php

namespace App\Contract;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface EmployeesImportService
{
    public function import(UploadedFile $file): void;
}
