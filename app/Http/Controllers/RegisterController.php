<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'username' => ['required', 'unique:users'],
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['isAdmin'] = 0;

        User::create($validatedData);

        return redirect()->route('login.index')->with('success', 'Register Berhasil!');
    }
}
