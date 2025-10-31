<?php

namespace App\Http\Requests\Blog;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can create blogs
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            // Image upload validation
            'image' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120',  // 5MB
                'dimensions:max_width=4096,max_height=4096',
            ],
        ];

        // Add validation for each locale
        foreach (config('app.locales', ['en', 'ar', 'fr']) as $locale) {
            $rules["title_{$locale}"] = [
                'required',
                'string',
                'max:255',
            ];
            $rules["description_{$locale}"] = [
                'required',
                'string',
                'min:50',
                'max:10000',
            ];
        }

        return $rules;
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [
            'image.required' => __('site.Blog image is required'),
            'image.image' => __('site.The file must be a valid image'),
            'image.mimes' => __('site.Image must be: JPEG, PNG, JPG, GIF, or WebP'),
            'image.max' => __('site.Image size must not exceed 5MB'),
            'image.dimensions' => __('site.Image dimensions must not exceed 4096x4096 pixels'),
        ];

        // Add messages for each locale
        foreach (config('app.locales', ['en', 'ar', 'fr']) as $locale) {
            $messages["title_{$locale}.required"] = __("site.Title in {$locale} is required");
            $messages["title_{$locale}.max"] = __("site.Title in {$locale} must not exceed 255 characters");
            $messages["description_{$locale}.required"] = __("site.Description in {$locale} is required");
            $messages["description_{$locale}.min"] = __("site.Description in {$locale} must be at least 50 characters");
            $messages["description_{$locale}.max"] = __("site.Description in {$locale} must not exceed 10000 characters");
        }

        return $messages;
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Server-side MIME type validation
            if ($this->hasFile('image')) {
                $image = $this->file('image');
                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                
                if (!in_array($image->getMimeType(), $allowedMimes)) {
                    $validator->errors()->add('image', __('site.Invalid image file type detected.'));
                }
            }
        });
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim all text inputs for each locale
        $mergeData = [];
        foreach (config('app.locales', ['en', 'ar', 'fr']) as $locale) {
            if ($this->has("title_{$locale}")) {
                $mergeData["title_{$locale}"] = trim($this->input("title_{$locale}"));
            }
            if ($this->has("description_{$locale}")) {
                $mergeData["description_{$locale}"] = trim($this->input("description_{$locale}"));
            }
        }
        
        $this->merge($mergeData);
    }
}
