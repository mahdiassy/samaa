<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Therapy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TherapySeeder extends Seeder
{
    public function run()
    {
        $userId = 1;

        for ($i = 1; $i <= 30; $i++) {
            $juz = str_pad($i, 2, '0', STR_PAD_LEFT);
            $name = 'Juz ' . $i;
            $albumName = 'Juz_' . $i;
            $imagePath = 'seed_files/Quran.png';
            $filePath = "seed_files/{$juz}.mp3";

            $album = Album::firstOrCreate(['name' => $albumName]);

            $therapy = new Therapy;
            $therapy->name = $name;
            $therapy->album_id = $album->id;
            $therapy->user_id = $userId;

            // For public disk (files in public/seed_files)
            if (file_exists(public_path($imagePath))) {
                $therapy->image = $this->storeFile($imagePath, 'Doctor therapy', 'public_disk');
            }

            if (file_exists(public_path($filePath))) {
                $therapy->file = $this->storeFileEncrypt($filePath, 'Doctor therapy', 'public_disk');
            } else {
                // Ensure non-null file column
                $therapy->file = encrypt('placeholder.mp3');
            }

            $therapy->save();
        }
    }

    public function storeFile(string $filePath, string $destinationPath = 'files', string $disk = 'public_disk')
    {
        $filename = time() . Str::random(3) . '-' . basename($filePath);
        $newPath = $destinationPath . '/' . $filename;

        if ($disk === 'public_disk') {
            // For files in public directory
            $fullPath = public_path($filePath);
            $content = file_get_contents($fullPath);
            Storage::disk('public')->put($newPath, $content);
        } else {
            // For files already in storage
            Storage::disk($disk)->copy($filePath, $newPath);
        }

        return $newPath;
    }

    public function storeFileEncrypt(string $filePath, string $destinationPath = 'files', string $disk = 'public_disk')
    {
        $filename = time() . Str::random(3) . '-' . basename($filePath);
        $newPath = $destinationPath . '/' . $filename;

        if ($disk === 'public_disk') {
            // For files in public directory
            $fullPath = public_path($filePath);
            $content = file_get_contents($fullPath);
            Storage::disk('public')->put($newPath, $content);
        } else {
            // For files already in storage
            Storage::disk($disk)->copy($filePath, $newPath);
        }

        return encrypt($filename);
    }
}
