<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function create(Request $request)
    {
        // we get the roles here which is used to show in the dropdown of the create form
        $roles = $request->user()->role->assignableRoles();

        return view('users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->withErrors(['message' => 'Failed to create user. Please try again']);
        }

        return redirect()->route('users.create')->with(['status' => 'User created. Temporary password sent by email']);

    }
}
