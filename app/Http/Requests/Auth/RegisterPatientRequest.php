<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterPatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can register as a patient
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $mergeData = [];

        // Map 'surname' to 'last_name' if it exists
        if ($this->has('surname')) {
            $mergeData['last_name'] = $this->input('surname');
        }

        // Map 'country' to 'country_id' for the service layer
        if ($this->has('country')) {
            $mergeData['country_id'] = $this->input('country');
        }
        
        // Map 'language' to 'language_id' for the service layer
        if ($this->has('language')) {
            $mergeData['language_id'] = $this->input('language');
        }
        
        if (!empty($mergeData)) {
            $this->merge($mergeData);
        }
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
            'gender' => [
                'required',
                'in:male,female',
            ],
            
            // Location & Language
            'country' => [
                'required',
                'exists:countries,id',
            ],
            'country_id' => [
                'required',
                'exists:countries,id',
            ],
            'language' => [
                'required',
                'exists:languages,id',
            ],
            'language_id' => [
                'required',
                'exists:languages,id',
            ],
            
            // Medical Information
            'open_description' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'therapeutic_areas' => [
                'required',
                'exists:therapeutic_areas,id',
            ],
            'medications' => [
                'nullable',
                'string',
                'max:1000',
                'required_if:therapeutic_areas,2',
            ],
            'addiction' => [
                'required',
                'exists:addictions,id',
            ],
            'consultation' => [
                'required',
                'exists:consultations,id',
            ],
            
            // Optional Medical Arrays
            'diseases' => [
                'nullable',
                'array',
            ],
            'diseases.*' => [
                'exists:diseases,id',
            ],
            'nervouses' => [
                'nullable',
                'array',
            ],
            'nervouses.*' => [
                'exists:nervouses,id',
            ],
            'symptoms' => [
                'nullable',
                'array',
            ],
            'symptoms.*' => [
                'exists:symptoms,id',
            ],
            'incidents' => [
                'nullable',
                'array',
            ],
            'incidents.*' => [
                'exists:incidents,id',
            ],
            'psychological_diseases' => [
                'nullable',
                'array',
            ],
            'psychological_diseases.*' => [
                'exists:psychologicals,id',
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
            'gender.required' => __('site.Gender is required'),
            'gender.in' => __('site.Gender must be male or female'),
            'country.required' => __('site.Country is required'),
            'country.exists' => __('site.Selected country is invalid'),
            'language.required' => __('site.Language is required'),
            'language.exists' => __('site.Selected language is invalid'),
            'therapeutic_areas.required' => __('site.Therapeutic area is required'),
            'addiction.required' => __('site.Addiction information is required'),
            'consultation.required' => __('site.Consultation information is required'),
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
            'gender' => __('site.Gender'),
            'country' => __('site.Country'),
            'language' => __('site.Language'),
            'open_description' => __('site.Description'),
            'therapeutic_areas' => __('site.Therapeutic Area'),
            'medications' => __('site.Medications'),
            'addiction' => __('site.Addiction'),
            'consultation' => __('site.Consultation'),
            'image' => __('site.Image'),
        ];
    }
}
