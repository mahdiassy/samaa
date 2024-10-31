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
    $filename = time() . \Str::random(3) . '-' . $file->getClientOriginalName();
    $storagePath = Storage::disk($disk)->path($path);
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }
    $file->move($storagePath, $filename);

    return $path . '/' . $filename;
}

public function storeFileEncrypt(UploadedFile $file, string $path = 'files', string $disk = 'public')
{
    $filename = time() . \Str::random(3) . '-' . $file->getClientOriginalName();
    $filenameEncrypt = encrypt($filename);
    $storagePath = Storage::disk($disk)->path($path);
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }
    $file->move($storagePath, $filename);
    return $filenameEncrypt;
}
}
