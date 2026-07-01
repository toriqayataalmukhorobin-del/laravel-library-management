<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->userDashboard($user);
    }

    private function adminDashboard()
    {
        $totalBooks    = Book::sum('stock');
        $totalUsers    = User::where('role', 'user')->count();
        $activeBorrowings  = Borrowing::where('status', 'borrowed')->count();
        $overdueBorrowings = Borrowing::where('status', 'borrowed')
                                     ->where('return_date', '<', Carbon::today())
                                     ->count();

        // --- Smart Stats ---
        // Most popular books (most borrowed)
        $popularBooks = Book::withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(5)
            ->get();

        // Most active users
        $activeUsers = User::where('role', 'user')
            ->withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(5)
            ->get();

        // Favourite categories
        $categoryStats = Category::withCount('books')
            ->orderByDesc('books_count')
            ->take(6)
            ->get();

        // Monthly borrowings chart (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $count = Borrowing::whereYear('borrow_date', $month->year)
                              ->whereMonth('borrow_date', $month->month)
                              ->count();
            $monthlyData[] = [
                'label' => $month->format('M Y'),
                'count' => $count,
            ];
        }

        $recentBorrowings = Borrowing::with(['user', 'book'])->latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalBooks', 'totalUsers', 'activeBorrowings', 'overdueBorrowings',
            'popularBooks', 'activeUsers', 'categoryStats',
            'monthlyData', 'recentBorrowings'
        ));
    }

    private function userDashboard($user)
    {
        $myActiveBorrowings = Borrowing::where('user_id', $user->id)
                                      ->where('status', 'borrowed')->count();
        $myTotalHistory = Borrowing::where('user_id', $user->id)->count();
        $myOverdue = Borrowing::where('user_id', $user->id)
                             ->where('status', 'borrowed')
                             ->where('return_date', '<', Carbon::today())->count();
        
        $borrowings = Borrowing::where('user_id', $user->id)->get();
        $myTotalFine = 0;
        foreach ($borrowings as $b) {
            if ($b->status === 'returned') {
                $myTotalFine += $b->fine;
            } elseif ($b->status === 'borrowed' && Carbon::parse($b->return_date)->isPast()) {
                $daysOverdue = Carbon::today()->diffInDays(Carbon::parse($b->return_date));
                $myTotalFine += ($daysOverdue * 1000);
            }
        }

        $myRecentBorrowings = Borrowing::with('book')
                                      ->where('user_id', $user->id)
                                      ->latest()->take(5)->get();

        return view('dashboard.user', compact(
            'myActiveBorrowings', 'myTotalHistory', 'myOverdue',
            'myTotalFine', 'myRecentBorrowings'
        ));
    }
}
