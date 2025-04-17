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

            if (Storage::disk('public')->exists($imagePath)) {
                $therapy->image = $this->storeFile($imagePath, 'Doctor therapy');
            }

            if (Storage::disk('public')->exists($filePath)) {
                $therapy->file = $this->storeFileEncrypt($filePath, 'Doctor therapy');
            }

            $therapy->save();
        }
    }

    public function storeFile(string $filePath, string $destinationPath = 'files', string $disk = 'public')
    {
        $filename = time() . Str::random(3) . '-' . basename($filePath);
        $newPath = $destinationPath . '/' . $filename;

        Storage::disk($disk)->copy($filePath, $newPath);

        return $newPath;
    }

    public function storeFileEncrypt(string $filePath, string $destinationPath = 'files', string $disk = 'public')
    {
        $filename = time() . Str::random(3) . '-' . basename($filePath);
        $newPath = $destinationPath . '/' . $filename;

        Storage::disk($disk)->copy($filePath, $newPath);

        return encrypt($filename);
    }

}
