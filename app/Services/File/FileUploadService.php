<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload an image file with security measures.
     *
     * @param UploadedFile $file The uploaded image file
     * @param string $directory The directory to store the file (e.g., 'patients', 'doctors', 'therapies')
     * @param string|null $oldFilePath Optional path to old file to delete
     * @return string The path to the uploaded file
     */
    public function uploadImage(UploadedFile $file, string $directory, ?string $oldFilePath = null): string
    {
        // Validate MIME type server-side (double-check)
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Invalid image file type: ' . $file->getMimeType());
        }

        // Generate secure random filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '_' . time() . '.' . $extension;

        // Store outside public directory for security
        $path = $file->storeAs(
            "uploads/{$directory}",
            $filename,
            'public'  // Uses storage/app/public
        );

        // Delete old file if provided
        if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
            Storage::disk('public')->delete($oldFilePath);
        }

        return $path;
    }

    /**
     * Upload an audio file with security measures.
     *
     * @param UploadedFile $file The uploaded audio file
     * @param string $directory The directory to store the file
     * @param string|null $oldFilePath Optional path to old file to delete
     * @return string The path to the uploaded file
     */
    public function uploadAudio(UploadedFile $file, string $directory, ?string $oldFilePath = null): string
    {
        // Validate MIME type server-side
        $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/aac', 'audio/flac', 'audio/x-m4a'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Invalid audio file type: ' . $file->getMimeType());
        }

        // Generate secure random filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '_' . time() . '.' . $extension;

        // Store in private directory (not accessible via URL)
        $path = $file->storeAs(
            "audio/{$directory}",
            $filename,
            'local'  // Uses storage/app (private)
        );

        // Delete old file if provided
        if ($oldFilePath && Storage::disk('local')->exists($oldFilePath)) {
            Storage::disk('local')->delete($oldFilePath);
        }

        return $path;
    }

    /**
     * Upload and encrypt an audio file for therapy sessions.
     *
     * @param UploadedFile $file The uploaded audio file
     * @param string $directory The directory to store the file
     * @param string|null $oldFilePath Optional path to old file to delete
     * @return string The path to the encrypted file
     */
    public function uploadEncryptedAudio(UploadedFile $file, string $directory, ?string $oldFilePath = null): string
    {
        // Validate MIME type server-side
        $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/aac', 'audio/flac', 'audio/x-m4a'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \InvalidArgumentException('Invalid audio file type: ' . $file->getMimeType());
        }

        // Generate secure random filename
        $extension = $file->getClientOriginalExtension();
        $filename = Str::random(40) . '_' . time() . '.' . $extension;

        // Read file contents
        $fileContents = file_get_contents($file->getRealPath());

        // Encrypt the file contents
        $encryptedContents = encrypt($fileContents);

        // Store encrypted file in private directory
        $path = "audio/{$directory}/{$filename}";
        Storage::disk('local')->put($path, $encryptedContents);

        // Delete old file if provided
        if ($oldFilePath && Storage::disk('local')->exists($oldFilePath)) {
            Storage::disk('local')->delete($oldFilePath);
        }

        return $path;
    }

    /**
     * Delete a file from storage.
     *
     * @param string $filePath The path to the file
     * @param string $disk The storage disk ('public' or 'local')
     * @return bool
     */
    public function deleteFile(string $filePath, string $disk = 'public'): bool
    {
        if (Storage::disk($disk)->exists($filePath)) {
            return Storage::disk($disk)->delete($filePath);
        }
        return false;
    }

    /**
     * Get the public URL for a file stored in the public disk.
     *
     * @param string $filePath The path to the file
     * @return string
     */
    public function getPublicUrl(string $filePath): string
    {
        return Storage::disk('public')->url($filePath);
    }

    /**
     * Download an encrypted audio file (decrypt on-the-fly).
     *
     * @param string $filePath The path to the encrypted file
     * @return string The decrypted file contents
     */
    public function downloadEncryptedAudio(string $filePath): string
    {
        if (!Storage::disk('local')->exists($filePath)) {
            throw new \Exception('File not found: ' . $filePath);
        }

        $encryptedContents = Storage::disk('local')->get($filePath);
        return decrypt($encryptedContents);
    }

    /**
     * Validate file size before upload (additional check).
     *
     * @param UploadedFile $file
     * @param int $maxSizeKB Maximum size in kilobytes
     * @return bool
     */
    public function validateFileSize(UploadedFile $file, int $maxSizeKB): bool
    {
        $fileSizeKB = $file->getSize() / 1024;
        return $fileSizeKB <= $maxSizeKB;
    }

    /**
     * Get file extension from MIME type (secure alternative to client extension).
     *
     * @param string $mimeType
     * @return string
     */
    protected function getExtensionFromMimeType(string $mimeType): string
    {
        $mimeMap = [
            // Images
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/webp' => 'webp',
            // Audio
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/ogg' => 'ogg',
            'audio/mp4' => 'm4a',
            'audio/x-m4a' => 'm4a',
            'audio/aac' => 'aac',
            'audio/flac' => 'flac',
        ];

        return $mimeMap[$mimeType] ?? 'bin';
    }
}
