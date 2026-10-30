<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for skills.
     */
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'category'    => ['required', 'string', 'in:backend,frontend,database,devops,tools'],
            'proficiency' => ['required', 'integer', 'min:1', 'max:100'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'experience'  => ['nullable', 'string', 'max:50'],
            'order'       => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }
}
