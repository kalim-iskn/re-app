<?php

namespace App\Contract\Entity\Repository;

use FileUploadInfoDTO;

interface FileUploadRepository
{
    public function save(FileUploadInfoDTO $dto): FileUploadInfoDTO;

    public function getById(int $id): FileUploadInfoDTO;
}
