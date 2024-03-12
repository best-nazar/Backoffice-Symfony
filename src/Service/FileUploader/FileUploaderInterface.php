<?php

namespace App\Service\FileUploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileUploaderInterface
{
    public const UPLOAD_PATH = '/uploads';

    public function upload(UploadedFile $file): bool;

    /** Uploaded file path name */
    public function getPath(): string;

    /** Uploading directory */
    public function getTargetDirectory(): string;

    /** File name with absolute path */
    public function getFullPath(): string;
}