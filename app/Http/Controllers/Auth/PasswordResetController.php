<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function sendLink(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $credentials['email'])->first();
        // dd($user);
        if (! $user) {
            return back()->withErrors(['email' => 'Email not found'])->onlyInput('email');
        }
        if ($user->status !== 'active') {
            return back()->withErrors(['email' => 'Account deactivated. Contact Support'])->onlyInput('email');
        }

        $status = Password::sendResetLink(['email' => $user->email, 'status' => 'active']);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)])->onlyInput('email');
    }

    public function resetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function updatePassword(Request $request)
    {
        $credentials = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset($request->only(
            'email', 'password', 'password_confirmation', 'token') + ['status' => 'active'], function (User $user, string $password) {
                $user->forceFill(['password' => $password]);
                $user->setRememberToken(Str::random(60));
                $user->save();
            });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)])->onlyInput('email');
    }
}
