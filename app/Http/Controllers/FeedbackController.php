<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = feedback::all();
        return view('dashboardPage.feedback', [
            'page' => 'Feedback'
        ])->with(compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'feedback' => 'required',
            ]);

            feedback::create($validatedData);

            return redirect()->route('feedback.index')->with('success', "Data Feedback $request->feedback berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('feedback.index')->with('failed', "Data $request->feedback gagal dibuat! " . $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, feedback $feedback)
    {
        try {
            $rules = [
                'feedback' => 'required',
            ];

            $validatedData = $this->validate($request, $rules);

            $feedback::where('id', $feedback->id)->update($validatedData);

            return redirect()->route('feedback.index')->with('success', "Data Feedback $feedback->feedback berhasil diperbarui!");
        } catch (\Illuminate\Validation\ValidationException $exception) {
            return redirect()->route('feedback.index')->with('failed', 'Data gagal diperbarui! ' . $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(feedback $feedback)
    {
        try {
            $feedback::destroy($feedback->id);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                //SQLSTATE[23000]: Integrity constraint violation
                return redirect()->route('feedback.index')->with('failed', "Feedback $feedback->feedback tidak dapat dihapus, karena sedang digunakan pada tabel lain!");
            }
        }

        return redirect()->route('feedback.index')->with('success', "Feedback $feedback->feedback berhasil dihapus!");
    }
}
