<?php

namespace App\DTO\Entity;

use DateTime;

class FileUploadInfoDTO
{
    public ?int $id = null;

    public string $fileName;

    public int $linesCount;

    public int $processedLinesCount = 0;

    public ?DateTime $createdAt = null;
}
