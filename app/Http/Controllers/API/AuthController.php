<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;


class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'nim' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['access_token' => $token, 'user_profile' => $user, 'mahasiswa' => $mahasiswa], 200);
        }

        return response()->json(['access_token' => null], 200);
    }

    public function profil(Request $request)
    {
        $user = Auth::user();
        return response()->json($user, 200);
    }
}
