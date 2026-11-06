<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ResetPasswordResult;
use App\Enums\SendLinkResult;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetEmailSendLinkRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\Request;

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
        $result = $this->passwordResetService->resetPassword($request->validated());

        return match ($result) {
            ResetPasswordResult::InvalidToken => back()->withErrors(['message' => __('passwords.token')])->onlyInput('email'),
            ResetPasswordResult::InvalidUser => back()->withErrors(['message' => __('passwords.user')])->onlyInput('email'),
            ResetPasswordResult::Reset => redirect()->route('login')->with('status', __('passwords.reset'))
        };
    }
}
