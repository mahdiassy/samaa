<?php

namespace App\Http\Requests\Therapy;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTherapyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Therapy Information
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'album_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'patient_id' => [
                'nullable',
                'exists:patients,id',
            ],
            
            // Audio File (Optional on update - only if replacing)
            'file' => [
                'nullable',
                'file',
                'mimes:mp3,wav,ogg,m4a,aac,flac',
                'max:102400',  // 100MB
            ],
            
            // Cover Image (Optional on update)
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120',  // 5MB
                'dimensions:max_width=4096,max_height=4096',
            ],
            
            // Waveform peaks
            'peaks' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => __('site.Therapy name is required'),
            'album_name.required' => __('site.Album name is required'),
            'file.file' => __('site.The uploaded item must be a valid file'),
            'file.mimes' => __('site.Audio file must be one of the following formats: MP3, WAV, OGG, M4A, AAC, FLAC'),
            'file.max' => __('site.Audio file size must not exceed 100MB'),
            'image.image' => __('site.Cover image must be a valid image file'),
            'image.mimes' => __('site.Cover image must be one of the following formats: JPEG, PNG, JPG, GIF, WebP'),
            'image.max' => __('site.Cover image size must not exceed 5MB'),
            'image.dimensions' => __('site.Image dimensions must not exceed 4096x4096 pixels'),
            'patient_id.exists' => __('site.Selected patient does not exist'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('site.Therapy Name'),
            'album_name' => __('site.Album Name'),
            'file' => __('site.Audio File'),
            'image' => __('site.Cover Image'),
            'patient_id' => __('site.Patient'),
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Server-side MIME type validation for audio
            if ($this->hasFile('file')) {
                $file = $this->file('file');
                $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/aac', 'audio/flac', 'audio/x-m4a'];
                
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    $validator->errors()->add('file', __('site.Invalid audio file type detected. File may be corrupted or not a valid audio file.'));
                }
            }
            
            // Server-side MIME type validation for image
            if ($this->hasFile('image')) {
                $image = $this->file('image');
                $allowedImageMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                
                if (!in_array($image->getMimeType(), $allowedImageMimes)) {
                    $validator->errors()->add('image', __('site.Invalid image file type detected.'));
                }
            }
        });
    }
}
