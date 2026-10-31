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
        try{
            $this->userService->createUser($request->validated());
        }catch(\Throwable $e) {
            report($e);
            return back()->withErrors(['message' => 'Failed to create user. Try again']);
        }
        return redirect()->route('users.create')->with(['status' => 'User create. Temporary password sent to mail']);
        
    }
}
