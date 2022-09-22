<?php

namespace App\Http\Controllers;

use App\Enum\RegLog;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function login()
    {
        return view('users.register-login', ['type' => RegLog::LOGIN]);
    }

    public function store()
    {
        $formFields = request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $formFields['password'] = bcrypt($formFields['password']);
        $user = User::create($formFields);
        auth()->login($user);
        return redirect('/')->with('message', 'User created and logged in!');
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/')->with('message', 'User logged out!');
    }

    public function authenticate()
    {
        $formFields = request()->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt($formFields)) {
            request()->session()->regenerate();
            return redirect('/')->with(['message' => 'You are now logged in']);
        }

        return back()->withErrors(['form' => 'Invalid credentials']);
    }
}
