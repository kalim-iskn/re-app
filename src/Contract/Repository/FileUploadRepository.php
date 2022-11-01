<?php

namespace App\Contract\Repository;

use FileUploadInfoDTO;

interface FileUploadRepository
{
    public function save(FileUploadInfoDTO $dto): FileUploadInfoDTO;

    public function getById(int $id): FileUploadInfoDTO;
}
