<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class ParentAuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register_parent');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => 'parent',
            'password' => Hash::make($request->password),
        ]);

        $user->parentProfile()->create([]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('parent.dashboard');
    }
}
