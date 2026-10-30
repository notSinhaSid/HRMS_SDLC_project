<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected UserService $userService;
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function create() {
        return view('users.create');
    }

    public function store(StoreUserRequest $request) {
        // $userData = $request->validated();
        $user = $this->userService->createUser($request->validated());
        return response([
            'status' => 'success',
            'data' => $user,
            'message' => 'New user added!'
        ], 201);
    }
}
