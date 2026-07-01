<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
                    ->withCount(['borrowings', 'borrowings as active_borrowings_count' => function ($query) {
                        $query->where('status', 'borrowed');
                    }])
                    ->withSum(['borrowings as total_fine' => function ($query) {
                        $query->where('status', 'returned');
                    }], 'fine')
                    ->latest()
                    ->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        // Hanya tampilkan user biasa (bukan admin)
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat melihat detail admin.');
        }

        $borrowings = Borrowing::where('user_id', $user->id)
                               ->with('book')
                               ->latest()
                               ->get();

        $activeBorrowings = $borrowings->where('status', 'borrowed')->count();
        $totalFine = $borrowings->where('status', 'returned')->sum('fine');

        return view('admin.users.show', compact('user', 'borrowings', 'activeBorrowings', 'totalFine'));
    }

    public function destroy(User $user)
    {
        // Jangan hapus admin
        if ($user->isAdmin()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun admin.');
        }

        // Cek apakah user masih punya peminjaman aktif
        $hasActiveBorrowing = Borrowing::where('user_id', $user->id)
                                       ->where('status', 'borrowed')
                                       ->exists();

        if ($hasActiveBorrowing) {
            return redirect()->route('users.index')
                           ->with('error', 'Tidak dapat menghapus user "' . $user->name . '" karena masih memiliki peminjaman aktif.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('users.index')
                       ->with('success', 'Pengguna "' . $name . '" berhasil dihapus.');
    }
}
