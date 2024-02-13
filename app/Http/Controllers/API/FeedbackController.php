<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'feedback' => 'required',
            ]);

            $feedback = feedback::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => "Data Feedback $feedback->feedback berhasil disimpan!",
                'data' => $feedback,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menyimpan data feedback: " . $exception->getMessage(),
            ], 422);
        }
    }
}
