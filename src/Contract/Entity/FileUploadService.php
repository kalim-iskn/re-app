<?php

namespace App\Contract\Entity;

use FileUploadInfoDTO;

interface FileUploadService
{
    public function getById(int $id): FileUploadInfoDTO;

    public function store(FileUploadInfoDTO $dto): FileUploadInfoDTO;

    public function addProcessedLine(int $id): void;
}
