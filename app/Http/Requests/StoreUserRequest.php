<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Override;

class StoreUserRequest extends FormRequest
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
           // role_id must be one of the roles the logged-in user is allowed to assign (recomputed each request, not trusted from the form)
            'role_id' => ['required', 'integer', Rule::in($this->user()->role->assignableRoles()->pluck('id')->all())],
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
        ];
    }

    #[Override]
    public function attributes():array
    {
        return [
            'role_id' => 'role'
        ];
    }
}
