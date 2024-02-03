<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::all();
        return view('dashboardPage.mahasiswa', [
            'page' => 'Mahasiswa'
        ])->with(compact('mahasiswas'));
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
            $validatedDataMahasiswa = $request->validate([
                'nama' => 'required|max:255',
                'nim' => ['required', 'max:16', 'regex:/^[0-9]+$/', 'unique:users'],
                'prodi' => 'required'
            ]);

            $validatedData['nim'] = $request->nim;
            $validatedData['name'] = $request->nama;
            $validatedData['password'] = Hash::make($request->nim);
            $validatedData['isAdmin'] = 0;
            $validatedData['username'] = strtolower(str_replace(' ', '', $request->nama));

            $user = User::create($validatedData);

            $validatedDataMahasiswa['user_id'] = $user->id;

            Mahasiswa::create($validatedDataMahasiswa);


            return redirect('/dashboard/mahasiswa')->with('success', 'Mahasiswa baru berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/mahasiswa')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/mahasiswa')->with('failed', $e->getMessage());
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
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        try {
            $rules = [
                'nama' => 'required|max:255',
                'nim' => 'required|max:255',
                'prodi' => 'required'
            ];

            $validatedData = $request->validate($rules);

            // Cek apakah 'nim' diubah, jika tidak, atur aturan validasi khusus
            if ($validatedData['nim'] === $mahasiswa->nim) {
                $rules['nim'] = 'required'; // 'nim' harus tetap sama dengan nilai saat ini
            } else {
                $rules['nim'] = ['required', 'unique:users,nim,' . $mahasiswa->id];
            }

            $validatedData = $request->validate($rules);

            $rules2 = [
                'nim' => 'required|max:255'
            ];

            $validatedData2 = $request->validate($rules2);

            User::where('nim', $mahasiswa->nim)->update($validatedData2);

            Mahasiswa::where('id', $mahasiswa->id)->update($validatedData);

            return redirect('/dashboard/mahasiswa')->with('success', 'Mahasiswa berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/mahasiswa')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/mahasiswa')->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        try {
            Mahasiswa::destroy($mahasiswa->id);
            User::where('nim', $mahasiswa->nim)->delete();
            return redirect('/dashboard/mahasiswa')->with('success', "Mahasiswa dengan Nama $mahasiswa->name berhasil dihapus!");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/dashboard/mahasiswa')->with('failed', "Mahasiswa $mahasiswa->name tidak bisa dihapus karena sedang digunakan!");
        }
    }
}
