<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = Category::all();
        return view('dashboardPage.category', [
            'page' => 'Category'
        ])->with(compact('categorys'));
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
                'category' => 'required|max:255',
            ]);

            Category::create($validated);

            return redirect('/dashboard/category')->with('success', 'Category baru berhasil dibuat!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/category')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/category')->with('failed', $e->getMessage());
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
    public function update(Request $request, Category $category)
    {
        try {
            $rules = [
                'category' => 'required|max:255',
            ];
            $validatedData = $request->validate($rules);

            Category::where('id', $category->id)->update($validatedData);

            return redirect('/dashboard/category')->with('success', 'Category berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/dashboard/category')->with('failed', $e->getMessage());
        } catch (\Exception $e) {
            return redirect('/dashboard/category')->with('failed', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            Category::destroy($category->id);
            return redirect('/dashboard/category')->with('success', "Category dengan Nama $category->category berhasil dihapus!");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/dashboard/category')->with('failed', "Category $category->category tidak bisa dihapus karena sedang digunakan!");
        }
    }
}
