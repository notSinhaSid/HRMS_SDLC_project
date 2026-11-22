<?php

return [
    'auth' => [
        'invalid_credentials' => 'Invalid credentials',
        'deactivated' => 'Account deactivated. Contact Support',
        'lockedout' => 'Too many attempts. Try again in :seconds seconds.',
    ],
    'password' => [
        'email_not_found' => 'Email not found',
    ],
    'users' => [
        'create_failed' => 'Failed to create user. Please try again.',
        'create_success' => 'User created. Temporary password sent to :email',
    ],
    'departments' => [
        'create_success' => 'Department :name created.',
        'update_success' => 'Department :name updated.',
    ],
    'designations' => [
        'create_success' => ':name designation added.',
        'update_success' => ':name designation updated.',
    ],
    'employees' => [
        'create_success' => 'Employee :name added',
        'create_failed' => 'Failed. Please try again.',
        'update_success' => 'Employee :name updated',
        'update_failed' => 'Failed to update. Try again.',
        'offboard_failed' => 'Failed to offboard :name. Please try again.',
        'offboard_success' => ':name has been offboarded.',
        'already_offboarded' => ':name is already offboarded.',
    ],
];
