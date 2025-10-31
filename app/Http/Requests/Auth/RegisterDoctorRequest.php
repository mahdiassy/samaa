<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterDoctorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can register as a doctor
        return true;
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
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
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
            'birthday' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01',
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
            ],
            
            // Professional Information
            'specialization' => [
                'required',
                'string',
                'max:255',
            ],
            'address' => [
                'nullable',
                'string',
                'max:500',
            ],
            
            // Profile Image
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
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
            'last_name.required' => __('site.Last name is required'),
            'email.required' => __('site.Email is required'),
            'email.email' => __('site.Email must be a valid email address'),
            'email.unique' => __('site.The email address is already in use by another user'),
            'password.required' => __('site.Password is required'),
            'password.confirmed' => __('site.Password confirmation does not match'),
            'birthday.required' => __('site.Birthday is required'),
            'birthday.before' => __('site.Birthday must be before today'),
            'phone.required' => __('site.Phone is required'),
            'specialization.required' => __('site.Specialization is required'),
            'image.image' => __('site.File must be an image'),
            'image.max' => __('site.Image size must not exceed 2MB'),
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
            'first_name' => __('site.First Name'),
            'last_name' => __('site.Last Name'),
            'email' => __('site.Email'),
            'password' => __('site.Password'),
            'birthday' => __('site.Birthday'),
            'phone' => __('site.Phone'),
            'specialization' => __('site.Specialization'),
            'address' => __('site.Address'),
            'image' => __('site.Image'),
        ];
    }
}
