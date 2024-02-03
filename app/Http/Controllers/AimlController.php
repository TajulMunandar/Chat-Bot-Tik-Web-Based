<?php

namespace App\Http\Controllers;

use App\Models\Aiml;
use App\Models\Category;
use Illuminate\Http\Request;

class AimlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = Category::all();
        $aimls = Aiml::with('category')->get();
        return view('dashboardPage.aiml', [
            'page' => 'Aiml'
        ])->with(compact('aimls', 'categorys'));
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
            $validated = $request->validate([
                'patern' => 'required',
                'template' => 'required',
                'category_id' => 'required',
            ]);

            Aiml::create($validated);

            return redirect('/dashboard/aiml')->with('success', 'Aiml baru berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/aiml')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/aiml')->with('failed', $e->getMessage());
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
    public function update(Request $request, Aiml $aiml)
    {
        try {
            $rules = [
                'patern' => 'required',
                'template' => 'required',
                'category_id' => 'required',
            ];
            $validatedData = $request->validate($rules);

            Aiml::where('id', $aiml->id)->update($validatedData);

            return redirect('/dashboard/aiml')->with('success', 'Aiml berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/aiml')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/aiml')->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aiml $aiml)
    {
        try {
            Aiml::destroy($aiml->id);
            return redirect('/dashboard/aiml')->with('success', "Aiml dengan Nama $aiml->patern berhasil dihapus!");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/dashboard/aiml')->with('failed', "Aiml $aiml->patern tidak bisa dihapus karena sedang digunakan!");
        }
    }
}
