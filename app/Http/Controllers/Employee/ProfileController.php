<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateChangePasswordRequest;

class ProfileController extends Controller
{
    public function showChangePassword()
    {
        return view('employees.profile.change-password');
    }

    public function updateChangePassword(UpdateChangePasswordRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();

        $user->forceFill([
            'password' => $validated['password'],
            'must_reset_password' => false,
        ]);
        $user->save();

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with(['status' => 'Password changed successfully.']);
    }
}
