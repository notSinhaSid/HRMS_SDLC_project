<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function showChangePassword()
    {
        return view('employees.profile.change-password');
    }

    public function updateChangePassword(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase(), 'different:current_password'],
            ['password.different' => 'New Password cannot be same as current password'],
            ['password.confirmed' => 'Password and confirm password did not match'],
        ]);

        $user->forceFill([
            'password' => $validated['password'],
            'must_reset_password' => false,
        ]);
        $user->save();

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with(['status' => 'Password changed successfully.']);
    }
}
