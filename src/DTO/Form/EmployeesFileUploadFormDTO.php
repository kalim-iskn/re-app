<?php

namespace App\DTO\Form;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class EmployeesFileUploadFormDTO
{
    protected UploadedFile $file;

    /**
     * @return UploadedFile
     */
    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file): void
    {
        $this->file = $file;
    }
}
