<?php
namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService {
    public function __construct(private UserRepository $userRepository)
    {}

    public function createUser(array $data): User {

        return DB::transaction(function () use ($data) {
            $tmpPassword = Str::random(16);
            $user = $this->userRepository->create([...$data, 'password'=>$tmpPassword]);
            // here will go the mail code
            return $user;
        });
    }
}