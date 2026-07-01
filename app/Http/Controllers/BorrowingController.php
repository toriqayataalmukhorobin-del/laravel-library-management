<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'all'); // all, online, offline
        
        $query = Borrowing::with(['user', 'book']);
        
        if ($user->isAdmin()) {
            // Admin can filter by type
            if ($filter === 'online') {
                $query->online();
            } elseif ($filter === 'offline') {
                $query->offline();
            }
            $borrowings = $query->latest()->get();
        } else {
            // Regular users only see their own online borrowings
            $borrowings = $query->where('user_id', $user->id)->latest()->get();
        }

        return view('borrowings.index', compact('borrowings', 'filter'));
    }

    public function store(Request $request, Book $book)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        // Cek jika user sudah meminjam buku ini
        $existingBorrowing = Borrowing::where('user_id', $user->id)
                                      ->where('book_id', $book->id)
                                      ->where('status', 'borrowed')
                                      ->first();
        if ($existingBorrowing) {
            return back()->withErrors(['message' => 'Anda sudah meminjam buku ini.']);
        }

        // Cek stok tersedia
        if (!$book->isAvailable()) {
            return back()->with('error', 'Maaf, stok buku ini sudah habis. Silakan gunakan fitur Booking untuk masuk antrian.');
        }

        Borrowing::create([
            'user_id'     => $user->id,
            'book_id'     => $book->id,
            'borrow_date' => Carbon::today(),
            'return_date' => Carbon::today()->addDays(7),
            'status'      => 'borrowed',
            'phone'       => $request->phone,
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Berhasil meminjam buku ' . $book->title);
    }

    public function markAsReturned(Borrowing $borrowing)
    {
        $fine = 0;
        $returnDate = Carbon::parse($borrowing->return_date);
        $today = Carbon::today();

        if ($today->gt($returnDate)) {
            $daysOverdue = $today->diffInDays($returnDate);
            $fine = $daysOverdue * 1000;
        }

        $borrowing->update(['status' => 'returned', 'fine' => $fine]);


        $message = 'Buku telah dikembalikan.';
        if ($fine > 0) {
            $message .= ' Terdapat denda keterlambatan sebesar Rp ' . number_format($fine, 0, ',', '.');
        }

        return redirect()->back()->with('success', $message);
    }

    public function createOffline()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $books = Book::all();
        return view('borrowings.create_offline', compact('books'));
    }

    public function storeOffline(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
            'notes' => 'nullable|string|max:500',
            'phone' => 'required|string|max:20',
        ]);

        // Cek stok tersedia
        $book = Book::find($request->book_id);
        if (!$book->isAvailable()) {
            return back()->withErrors(['message' => 'Maaf, stok buku ini sudah habis.']);
        }

        // Cek jika nama peminjam yang sama sudah meminjam buku ini (untuk offline)
        $existingBorrowing = Borrowing::where('book_id', $request->book_id)
                                      ->where('borrower_name', $request->borrower_name)
                                      ->where('status', 'borrowed')
                                      ->first();
                                      
        if ($existingBorrowing) {
            return back()->withErrors(['message' => 'Peminjam ini sudah meminjam buku ini.']);
        }

        Borrowing::create([
            'user_id' => null, // Offline borrowing has no user
            'borrower_name' => $request->borrower_name,
            'book_id' => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status' => 'borrowed',
            'notes' => $request->notes,
            'phone' => $request->phone,
        ]);

        return redirect()->route('borrowings.index', ['filter' => 'offline'])
                        ->with('success', 'Berhasil menambah peminjaman offline untuk ' . $request->borrower_name);
    }

    public function print(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $filter = $request->query('filter', 'all');
        $query = Borrowing::with(['user', 'book']);
        
        if ($filter === 'online') {
            $query->online();
        } elseif ($filter === 'offline') {
            $query->offline();
        }
        
        $borrowings = $query->latest()->get();
        $date = Carbon::now()->format('d F Y');

        return view('borrowings.print', compact('borrowings', 'filter', 'date'));
    }
}
