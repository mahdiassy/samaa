<?php

namespace App\Http\Requests\Patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admin can create patients via admin panel
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Personal Information
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s\-]+$/u',  // Letters, spaces, hyphens only
            ],
            'surname' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s\-]+$/u',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[\d\s\+\-\(\)]+$/',  // International phone format
                'max:20',
            ],
            'age' => [
                'required',
                'integer',
                'min:13',  // Minimum age for mental health services
                'max:120',
            ],
            'gender' => [
                'required',
                'in:male,female,other',
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            'country_id' => [
                'nullable',
                'exists:countries,id',
            ],
            'language_id' => [
                'nullable',
                'exists:languages,id',
            ],
            
            // Account Information
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            
            // Profile Image
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',  // 2MB
                'dimensions:max_width=2048,max_height=2048',
            ],
            
            // Medical Information
            'therapeutic_area' => [
                'nullable',
                'array',
            ],
            'therapeutic_area.*' => [
                'integer',
                'exists:therapeutic_areas,id',
            ],
            'diseases' => [
                'nullable',
                'array',
            ],
            'diseases.*' => [
                'integer',
                'exists:diseases,id',
            ],
            'symptoms' => [
                'nullable',
                'array',
            ],
            'symptoms.*' => [
                'integer',
                'exists:symptoms,id',
            ],
            'addiction' => [
                'nullable',
                'array',
            ],
            'addiction.*' => [
                'integer',
                'exists:addictions,id',
            ],
            'consultations' => [
                'nullable',
                'array',
            ],
            'consultations.*' => [
                'integer',
                'exists:consultations,id',
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
            'first_name.required' => __('site.First name is required'),
            'first_name.regex' => __('site.First name can only contain letters, spaces, and hyphens'),
            'surname.required' => __('site.Surname is required'),
            'surname.regex' => __('site.Surname can only contain letters, spaces, and hyphens'),
            'phone.required' => __('site.Phone number is required'),
            'phone.regex' => __('site.Invalid phone number format'),
            'age.required' => __('site.Age is required'),
            'age.min' => __('site.Minimum age is 13 years'),
            'age.max' => __('site.Please enter a valid age'),
            'gender.required' => __('site.Gender is required'),
            'gender.in' => __('site.Invalid gender selection'),
            'email.required' => __('site.Email is required'),
            'email.email' => __('site.Please enter a valid email address'),
            'email.unique' => __('site.This email is already registered'),
            'password.required' => __('site.Password is required'),
            'password.confirmed' => __('site.Password confirmation does not match'),
            'image.image' => __('site.Profile picture must be a valid image'),
            'image.mimes' => __('site.Profile picture must be: JPEG, PNG, JPG, GIF, or WebP'),
            'image.max' => __('site.Profile picture size must not exceed 2MB'),
            'image.dimensions' => __('site.Image dimensions must not exceed 2048x2048 pixels'),
            'country_id.exists' => __('site.Selected country does not exist'),
            'language_id.exists' => __('site.Selected language does not exist'),
        ];
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
        // Trim all text inputs
        $this->merge([
            'first_name' => $this->first_name ? trim($this->first_name) : null,
            'surname' => $this->surname ? trim($this->surname) : null,
            'email' => $this->email ? trim(strtolower($this->email)) : null,
            'phone' => $this->phone ? trim($this->phone) : null,
            'address' => $this->address ? trim($this->address) : null,
        ]);
    }
}
