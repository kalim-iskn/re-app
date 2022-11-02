<?php

namespace App\Job;

class EmployeesFileProcessingMessage
{
    const LINES_COUNT = 10000;

    protected int $fileUploadId;
    protected int $startLineNumber;

    public function __construct(int $fileUploadId, int $startLineNumber)
    {
        $this->fileUploadId = $fileUploadId;
        $this->startLineNumber = $startLineNumber;
    }

    /**
     * @return int
     */
    public function getFileUploadId(): int
    {
        return $this->fileUploadId;
    }

    /**
     * @return int
     */
    public function getStartLineNumber(): int
    {
        return $this->startLineNumber;
    }
}
