<?php

namespace App\Http\Controllers\Auth;

use App\Enums\SendLinkResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetEmailSendLinkRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Models\User;
use App\Services\PasswordResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function __construct(private PasswordResetService $passwordResetService) {}

    public function showForgot()
    {
        return view('auth.forgot-password');
    }

    public function sendLink(PasswordResetEmailSendLinkRequest $request)
    {
        $result = $this->passwordResetService->sendLink($request->validated());

        return match ($result) {
            SendLinkResult::NotFound => back()->withErrors(['email' => 'Email not found'])->onlyInput('email'),
            SendLinkResult::Deactivated => back()->withErrors(['message' => 'Account deactivated. Contact Support'])->onlyInput('email'),
            SendLinkResult::Throttled => back()->withErrors(['message' => __('passwords.throttled')])->onlyInput('email'),
            SendLinkResult::Sent => back()->with('status', __('passwords.sent')),
        };
    }

    public function resetPassword(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function updatePassword(PasswordResetRequest $request)
    {
        $credentials = $request->validated();

        $status = Password::reset($request->only(
            'email', 'password', 'password_confirmation', 'token') + ['status' => 'active'], function (User $user, string $password) {
                $user->forceFill(['password' => $password]);
                $user->setRememberToken(Str::random(60));
                $user->save();
            });

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['message' => __($status)])->onlyInput('email');
    }
}
