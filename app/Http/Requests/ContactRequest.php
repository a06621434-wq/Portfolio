<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates and sanitizes incoming contact form submissions.
 * Protects against XSS by stripping tags from all input.
 */
class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public form — no auth required
    }

    public function rules(): array
    {
        return [
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * Sanitize input to prevent XSS.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'    => strip_tags($this->name ?? ''),
            'subject' => strip_tags($this->subject ?? ''),
            'message' => strip_tags($this->message ?? ''),
        ]);
    }
}
