<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class FileHelper
{
    /**
     * Store the uploaded file in the specified location within the public directory using the move function.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string $fileName
     * @return string|null
     */
    public static function storeFile(UploadedFile $file, string $folder, string $fileName): ?string
    {
        try {
            $folderPath = public_path($folder);
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $file->move($folderPath, $fileName);
            return asset($folder . '/' . $fileName);
        } catch (\Exception $e) {
            return null;
        }
    }
}