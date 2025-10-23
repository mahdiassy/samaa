<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Upload Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for file uploads including size limits
    | and validation rules for different file types.
    |
    */

    'max_file_size' => env('MAX_FILE_SIZE', 100 * 1024 * 1024), // 100MB in bytes
    'max_audio_size' => env('MAX_AUDIO_SIZE', 100 * 1024 * 1024), // 100MB in bytes
    'max_image_size' => env('MAX_IMAGE_SIZE', 10 * 1024 * 1024), // 10MB in bytes
    
    'allowed_audio_types' => [
        'audio/mpeg',
        'audio/mp3',
        'audio/wav',
        'audio/mpeg',
        'audio/x-mpeg',
        'audio/mp4',
        'audio/x-mp4',
        'audio/aac',
        'audio/ogg',
        'audio/webm'
    ],
    
    'allowed_image_types' => [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/gif',
        'image/webp'
    ],
    
    'upload_timeout' => env('UPLOAD_TIMEOUT', 300), // 5 minutes
];
