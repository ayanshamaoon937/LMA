<?php

namespace App\Http\Requests\Front;

use Illuminate\Foundation\Http\FormRequest;

class SubmitJobApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:255'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'cv' => ['required', 'exists:job_application_cvs,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'cv.required' => 'Please upload your CV before submitting the application.',
            'cv.exists' => 'The uploaded CV is invalid or has expired.',
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'position.required' => 'Please select a position.',
        ];
    }
}
