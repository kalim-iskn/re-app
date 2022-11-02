<?php

namespace App\Contract\Entity\Service;

use FileUploadInfoDTO;

interface FileUploadService
{
    public function getById(int $id): FileUploadInfoDTO;

    public function store(FileUploadInfoDTO $dto): FileUploadInfoDTO;

    public function addProcessedLines(int $id, int $count): void;
}
