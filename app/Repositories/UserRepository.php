<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
   public function create(array $data): User {
    $user = (new User())->forceFill([
        'role_id' => $data['role_id'],
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'status' => 'active',
        'must_reset_password' => true,
    ]);
    $user->save();
    return $user;
   }

   public function update(User $user, array $data): User {
    $user->update($data);
    return $user;
   }
}
