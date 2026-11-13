<?php

namespace App\Http\Requests\Designation;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:designations,name'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('name')) {
            $name = preg_replace('/\s+/', ' ', trim($this->name));
            $this->merge(['name' => ucfirst(strtolower($name))]);
        }
    }
}
