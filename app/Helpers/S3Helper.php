<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class S3Helper
{
    public static function uploadFile($file, $folder)
    {
        return Storage::disk('s3')->put($folder, $file);
    }

    public static function deleteFile($path)
    {
        return Storage::disk('s3')->delete($path);
    }
}