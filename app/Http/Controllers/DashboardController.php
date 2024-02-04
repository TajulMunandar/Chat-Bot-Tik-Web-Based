<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aimlFile = storage_path('app/public/chatbot.xml');
        $xmlString = File::get($aimlFile);

        // Mengonversi string XML menjadi objek SimpleXMLElement
        $xml = simplexml_load_string($xmlString);

        // Inisialisasi jumlah pola
        $aiml = 0;

        // Menghitung jumlah pola
        foreach ($xml->category as $category) {
            $pattern = Str::lower(trim((string)$category->pattern));
            if (!empty($pattern)) {
                $aiml++;
            }
        }

        $mahasiswa = Mahasiswa::count();
        $category = Category::count();
        return view('dashboardPage.index', [
            'page' => 'Dashboard'
        ])->with(compact('aiml', 'mahasiswa', 'category'));
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
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
