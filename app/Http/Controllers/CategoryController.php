<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dengan jumlah Todo yang terkait
        $categories = Category::withCount('todos')->get();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        // Validasi input nama kategori
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan kategori baru ke database
        Category::create($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function destroy(Category $category)
    {
        // Hapus kategori
        $category->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
