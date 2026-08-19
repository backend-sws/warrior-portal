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

        // Notify Admin
        \App\Helpers\NotificationHelper::notifyAdmin(
            'New Parent Registered',
            $user->name . ' has registered as a parent/tuition seeker.',
            route('admin.users.index'),
            'fas fa-user-friends'
        );

        // Notify User
        \App\Helpers\NotificationHelper::notifyUser(
            $user->id,
            'Welcome to Warriors Educare',
            'Your account has been created successfully.',
            route('parent.dashboard'),
            'fas fa-user',
            true
        );

        return redirect()->route('parent.dashboard');
    }
}
