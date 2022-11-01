<?php

namespace App\Service;

use App\Contract\FileUploadService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadServiceImpl implements FileUploadService
{
    public function upload(UploadedFile $file, string $dir): string
    {
        $fileName = md5($file->getClientOriginalName() . uniqid() . microtime()) . ".csv";
        $file->move(
            $dir,
            $fileName
        );
        return $fileName;
    }
}
