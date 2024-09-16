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
        $filename = $path . '/' . time() . \Str::random(3) . '-' . $file->getClientOriginalName();
        Storage::disk($disk)->put($filename, file_get_contents($file));
        return $filename;
    }

    public function storeFileEncrypt(UploadedFile $file, string $path = 'files', string $disk = 'public')
    {
        $filename = $path . '/' . time() . \Str::random(3) . '-' . $file->getClientOriginalName();
        $filenameEncrypt = encrypt($filename);
        Storage::disk($disk)->put($filename, file_get_contents($file));
        return $filenameEncrypt;
    }
}
