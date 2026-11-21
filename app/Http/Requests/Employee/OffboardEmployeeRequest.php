<?php

namespace App\Http\Requests\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class OffboardEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        $employee = $this->route('employee');
        $roleId = $employee->user?->role_id;
        if ($roleId === null) {
            return false;
        }

        return in_array($roleId, $this->user()->role->assignableRoles()->pluck('id')->all(), true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_of_leaving' => ['required', 'date', 'after_or_equal:'.$this->route('employee')->date_of_joining->format('Y-m-d')],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $employee = $this->route('employee');
                if ($employee->user?->status !== 'active') {
                    $validator->errors()->add('message', __('messages.employees.already_offboarded', ['name' => $employee->user?->name]));
                }
            },
        ];
    }
}
