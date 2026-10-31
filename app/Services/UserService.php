<?php
namespace App\Services;

use App\Mail\TempPasswordMail;
use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService {
    public function __construct(private UserRepository $userRepository)
    {}

    public function createUser(array $data): User {

        return DB::transaction(function () use ($data) {
            $tmpPassword = Str::random(16);
            $user = $this->userRepository->create([...$data, 'password'=>$tmpPassword]);
            Mail::to($user->email)->send(new TempPasswordMail($tmpPassword, $user->email, $user->name));
            return $user;
        });
    }
}