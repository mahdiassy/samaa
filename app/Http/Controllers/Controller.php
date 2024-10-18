<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function storeFile(UploadedFile $file, string $path = 'files', string $disk = 'public')
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());

        $filename = $path . '/' . time() . \Str::random(3) . '-' . $originalName . '.' . $extension;

        Storage::disk($disk)->put($filename, file_get_contents($file));

        return $filename;
    }

    public function storeFileEncrypt(UploadedFile $file, string $path = 'files', string $disk = 'public')
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());

        $filename = $path . '/' . time() . \Str::random(3) . '-' . $originalName . '.' . $extension;

        $filenameEncrypt = encrypt($filename);

        Storage::disk($disk)->put($filename, file_get_contents($file));

        return $filenameEncrypt;
    }
}
