<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // User: View their own messages
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('user_id', $user->id)
                          ->with('user')
                          ->latest()
                          ->get();
        
        return view('messages.index', compact('messages'));
    }

    // User: Create new message
    public function create()
    {
        return view('messages.create');
    }

    // User: Store message
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return redirect()->route('messages.index')
                        ->with('success', 'Pesan berhasil dikirim ke admin.');
    }

    // Admin: View all messages
    public function adminIndex()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $messages = Message::with('user')
                          ->latest()
                          ->get();
        
        return view('messages.admin', compact('messages'));
    }

    // Admin: View single message
    public function show(Message $message)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // Mark as read if unread
        if ($message->status === 'unread') {
            $message->markAsRead();
        }

        return view('messages.show', compact('message'));
    }

    // Admin: Reply to message
    public function reply(Request $request, Message $message)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'reply' => 'required|string|max:2000',
        ]);

        $message->markAsReplied($request->reply);

        return redirect()->route('messages.admin')
                        ->with('success', 'Balasan berhasil dikirim.');
    }

    // User: View their message with admin reply
    public function userShow(Message $message)
    {
        if ($message->user_id !== Auth::id()) {
            abort(403);
        }

        return view('messages.user-show', compact('message'));
    }
}
