<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nim' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->isAdmin == 1) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            } else {
                Auth::logout();
                return back()->with('failed', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
            }
        }

        return back()->with('failed', 'Login Gagal, periksa kembali username atau password anda!');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
