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
                    ->latest()
                    ->get();

        return view('admin.users.index', compact('users'));
    }
}
