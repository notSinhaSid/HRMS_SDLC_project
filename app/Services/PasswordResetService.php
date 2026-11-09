<?php

namespace App\Services;

use App\Enums\ResetPasswordResult;
use App\Enums\SendLinkResult;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetService
{
    public function sendLink(array $data): SendLinkResult
    {
        $user = User::where('email', $data['email'])->first();
        if (! $user) {
            return SendLinkResult::NotFound;
        }

        if ($user->status !== 'active') {
            return SendLinkResult::Deactivated;
        }

        $status = Password::sendResetLink(['email' => $data['email'], 'status' => 'active']);

        return match ($status) {
            Password::RESET_LINK_SENT => SendLinkResult::Sent,
            Password::RESET_THROTTLED => SendLinkResult::Throttled,
            default => SendLinkResult::NotFound
        };
    }

    public function resetPassword(array $data): ResetPasswordResult
    {
        $status = Password::reset($data + ['status' => 'active'], function (User $user, string $password) {
            $user->forceFill(['password' => $password]);
            $user->setRememberToken(Str::random(60));
            $user->save();
        });

        if ($status === Password::PASSWORD_RESET) {
            return ResetPasswordResult::Reset;
        }

        if ($status === Password::INVALID_TOKEN) {
            return ResetPasswordResult::InvalidToken;
        }

        return ResetPasswordResult::InvalidUser;
    }
}
