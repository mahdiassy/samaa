<?php

namespace App\Http\Requests\Feedback;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeedbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Anyone can submit feedback/contact form
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
            // Name fields - either full_name OR (first_name + surname)
            'full_name' => [
                'nullable',
                'required_without_all:first_name,surname',
                'string',
                'max:255',
            ],
            'first_name' => [
                'nullable',
                'required_without:full_name',
                'string',
                'max:255',
            ],
            'surname' => [
                'nullable',
                'required_with:first_name',
                'string',
                'max:255',
            ],
            
            // Contact Information
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            
            // Message Content
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'message' => [
                'required',
                'string',
                'min:10',
                'max:5000',
            ],
            
            // CTA Tracking (optional)
            'cta_source' => [
                'nullable',
                'string',
                'max:255',
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
            'full_name.required_without_all' => __('site.Name is required'),
            'first_name.required_without' => __('site.First name is required when full name is not provided'),
            'surname.required_with' => __('site.Surname is required when first name is provided'),
            'email.required' => __('site.Email is required'),
            'email.email' => __('site.Email must be a valid email address'),
            'subject.required' => __('site.Subject is required'),
            'message.required' => __('site.Message is required'),
            'message.min' => __('site.Message must be at least 10 characters'),
            'message.max' => __('site.Message must not exceed 5000 characters'),
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
            'full_name' => __('site.Full Name'),
            'first_name' => __('site.First Name'),
            'surname' => __('site.Surname'),
            'email' => __('site.Email'),
            'subject' => __('site.Subject'),
            'message' => __('site.Message'),
            'cta_source' => __('site.CTA Source'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from all string inputs
        $this->merge([
            'full_name' => $this->full_name ? trim($this->full_name) : null,
            'first_name' => $this->first_name ? trim($this->first_name) : null,
            'surname' => $this->surname ? trim($this->surname) : null,
            'email' => $this->email ? trim($this->email) : null,
            'subject' => $this->subject ? trim($this->subject) : null,
            'message' => $this->message ? trim($this->message) : null,
        ]);
    }
}
