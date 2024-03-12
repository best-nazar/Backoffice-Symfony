<?php

namespace App\Service\FileUploader;

class ImageUploader extends FileUploader
{
    public const IMAGE_PATH = '/images';

    public function getPath(): string
    {
        return self::UPLOAD_PATH . self::IMAGE_PATH . '/' . $this->filePath;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory . self::UPLOAD_PATH . self::IMAGE_PATH;
    }

    public function getFullPath(): string
    {
        return $this->targetDirectory . self::UPLOAD_PATH . self::IMAGE_PATH . '/' . $this->filePath;
    }
}
