<?php

namespace App\Http\Controllers;

use App\Models\Aiml;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function chat(Request $request)
    {
        $userInput = strtolower($request->input('user_input'));

        // Mencari aturan AIML yang cocok berdasarkan pola
        $aimlRule = Aiml::where('patern', $userInput)->first();

        // Jika aturan ditemukan, kirim respons
        if ($aimlRule) {
            $response = $aimlRule->template;
        } else {
            // Jika tidak ada aturan yang cocok, kirim respons default atau pesan kesalahan
            $response = "Maaf, saya tidak mengerti pertanyaan Anda.";
        }

        return response()->json(['response' => $response]);
    }
}
