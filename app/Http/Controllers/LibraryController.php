<?php

namespace App\Http\Controllers;

use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function map()
    {
        $libraries = Library::where('is_active', true)->get();
        return view('libraries.map', compact('libraries'));
    }

    public function index()
    {
        $libraries = Library::all();
        return view('libraries.index', compact('libraries'));
    }

    public function create()
    {
        return view('libraries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'opening_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        Library::create($validated);

        return redirect()->route('libraries.index')->with('success', 'Perpustakaan berhasil ditambahkan');
    }

    public function edit(Library $library)
    {
        return view('libraries.edit', compact('library'));
    }

    public function update(Request $request, Library $library)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'opening_hours' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $library->update($validated);

        return redirect()->route('libraries.index')->with('success', 'Perpustakaan berhasil diperbarui');
    }

    public function destroy(Library $library)
    {
        $library->delete();

        return redirect()->route('libraries.index')->with('success', 'Perpustakaan berhasil dihapus');
    }
}
