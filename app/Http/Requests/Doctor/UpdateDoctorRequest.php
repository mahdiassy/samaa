<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $doctorId = $this->route('doctor');
        
        return [
            // Personal Information
            'first_name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s\-]+$/u',
            ],
            'surname' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'regex:/^[\p{L}\s\-]+$/u',
            ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'regex:/^[\d\s\+\-\(\)]+$/',
                'max:20',
            ],
            'age' => [
                'sometimes',
                'required',
                'integer',
                'min:25',
                'max:80',
            ],
            'gender' => [
                'sometimes',
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
            
            // Professional Information
            'specialization' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],
            'license_number' => [
                'nullable',
                'string',
                'max:100',
            ],
            'years_experience' => [
                'nullable',
                'integer',
                'min:0',
                'max:60',
            ],
            'bio' => [
                'nullable',
                'string',
                'max:2000',
            ],
            
            // Account Information
            'email' => [
                'sometimes',
                'required',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')->ignore($doctorId),
            ],
            'password' => [
                'nullable',
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
                'max:2048',
                'dimensions:max_width=2048,max_height=2048',
            ],
            
            // Therapeutic Areas
            'therapeutic_areas' => [
                'nullable',
                'array',
            ],
            'therapeutic_areas.*' => [
                'integer',
                'exists:therapeutic_areas,id',
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
            'age.min' => __('site.Minimum age for doctors is 25 years'),
            'age.max' => __('site.Please enter a valid age'),
            'gender.required' => __('site.Gender is required'),
            'gender.in' => __('site.Invalid gender selection'),
            'specialization.required' => __('site.Specialization is required'),
            'email.required' => __('site.Email is required'),
            'email.email' => __('site.Please enter a valid email address'),
            'email.unique' => __('site.This email is already registered'),
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
        $this->merge([
            'first_name' => $this->first_name ? trim($this->first_name) : null,
            'surname' => $this->surname ? trim($this->surname) : null,
            'email' => $this->email ? trim(strtolower($this->email)) : null,
            'phone' => $this->phone ? trim($this->phone) : null,
            'address' => $this->address ? trim($this->address) : null,
            'specialization' => $this->specialization ? trim($this->specialization) : null,
        ]);
    }
}
