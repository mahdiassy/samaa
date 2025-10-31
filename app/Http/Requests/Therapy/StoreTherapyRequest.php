<?php

namespace App\Http\Requests\Therapy;

use Illuminate\Foundation\Http\FormRequest;

class StoreTherapyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization should be handled by policies
        // For now, allow authenticated users
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
                'required',
                'string',
                'max:255',
            ],
            'album_name' => [
                'required',
                'string',
                'max:255',
            ],
            'patient_id' => [
                'nullable',
                'exists:patients,id',
            ],
            
            // Audio File (CRITICAL - Main therapy file)
            'file' => [
                'required',
                'file',
                'mimes:mp3,wav,ogg,m4a,aac,flac',  // Allowed audio formats
                'max:102400',  // 100MB in kilobytes (100 * 1024)
            ],
            
            // Cover Image (Optional)
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120',  // 5MB in kilobytes
                'dimensions:max_width=4096,max_height=4096',  // Prevent huge images
            ],
            
            // Waveform peaks (Optional - generated data)
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
            'file.required' => __('site.Audio file is required'),
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
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation: Check actual file MIME type (not just extension)
            if ($this->hasFile('file')) {
                $file = $this->file('file');
                $allowedMimes = ['audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/aac', 'audio/flac', 'audio/x-m4a'];
                
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    $validator->errors()->add('file', __('site.Invalid audio file type detected. File may be corrupted or not a valid audio file.'));
                }
            }
            
            // Additional validation for image MIME type
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
