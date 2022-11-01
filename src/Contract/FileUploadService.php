<?php

namespace App\Contract;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploadService
{
    public function upload(UploadedFile $file, string $dir): string;
}
