<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'nullable|integer|min:1000|max:9999',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'required|integer|min:1',
        ]);

        Book::create($request->only(['title','author','publisher','year','description','category_id','stock']));

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'nullable|string|max:255',
            'publisher'   => 'nullable|string|max:255',
            'year'        => 'nullable|integer|min:1000|max:9999',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'stock'       => 'required|integer|min:1',
        ]);

        // Warn if new stock is less than currently borrowed
        $activeBorrowed = $book->activeBorrowingsCount();
        if ($request->stock < $activeBorrowed) {
            return back()->withErrors(['stock' => "Stok tidak bisa kurang dari jumlah yang sedang dipinjam ($activeBorrowed buku)."])->withInput();
        }

        $book->update($request->only(['title','author','publisher','year','description','category_id','stock']));

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
