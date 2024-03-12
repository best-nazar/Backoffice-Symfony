<?php

namespace App\Service\FileUploader;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader implements FileUploaderInterface
{
    protected string $filePath;

    public function __construct(
        // check services.yaml for Service configuration
        protected string $targetDirectory,
        protected SluggerInterface $slugger,
    ) {
    }

    public function upload(UploadedFile $file): bool
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
            $this->filePath = $fileName;

            return true;
        } catch (FileException $e) {
            return false;
        }
    }

    public function getPath(): string
    {
        return self::UPLOAD_PATH . $this->filePath;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory . self::UPLOAD_PATH;
    }

    public function getFullPath(): string
    {
        return $this->targetDirectory . self::UPLOAD_PATH . $this->filePath;
    }
}
