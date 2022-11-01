<?php

namespace App\Job;

class EmployeesFileProcessingMessage
{
    private int $fileUploadId;

    public function __construct(int $fileUploadId)
    {
        $this->fileUploadId = $fileUploadId;
    }

    /**
     * @return int
     */
    public function getFileUploadId(): int
    {
        return $this->fileUploadId;
    }
}
