<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $categories = Category::withCount(['books'])->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name',
            'icon'  => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);
        Category::create($request->only(['name', 'icon', 'color']));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $request->validate([
            'name'  => 'required|string|max:100|unique:categories,name,' . $category->id,
            'icon'  => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);
        $category->update($request->only(['name', 'icon', 'color']));
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if (!Auth::user()->isAdmin()) abort(403);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
