<?php

namespace App\Services;

use App\Enums\SendLinkResult;
use App\Models\User;
use Illuminate\Support\Facades\Password;

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

        if ($status === Password::RESET_LINK_SENT) {

            return SendLinkResult::Sent;
        }

        return SendLinkResult::Throttled;
    }
}
