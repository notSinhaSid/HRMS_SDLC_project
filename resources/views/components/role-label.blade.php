@props(['role' => null])
{{-- Human readable role name: 'super_admin' => 'Super Admin', 'hr' => 'HR' --}}
{{ [
    'super_admin' => 'Super Admin',
    'hr' => 'HR',
    'manager' => 'Manager',
    'employee' => 'Employee',
][$role] ?? \Illuminate\Support\Str::headline((string) $role) }}
