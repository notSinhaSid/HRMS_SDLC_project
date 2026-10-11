<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $user = User::where('email', $validated['email'])->first();
        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['message' => 'Invalid credentials'])->onlyInput('email');
        }
        if (Auth::user()->status !== 'active') {
            return back()->withErrors(['message' => 'Account deactived. Contact Support'])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));

    }
}
