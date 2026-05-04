<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function image(?UploadedFile $file, string $directory): ?string
    {
        if (! $file) {
            return null;
        }

        return Storage::url($file->store($directory, 'public'));
    }
}
