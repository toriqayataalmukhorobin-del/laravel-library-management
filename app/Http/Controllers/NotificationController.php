<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // [ADMIN] Halaman kirim notifikasi
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('notifications.create', compact('users'));
    }

    // [ADMIN] Simpan notifikasi baru
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'message'      => 'required|string',
            'recipient'    => 'required|in:all,specific',
            'user_id'      => 'required_if:recipient,specific|nullable|exists:users,id',
        ]);

        $isBroadcast = $request->recipient === 'all';

        Notification::create([
            'sender_id'    => Auth::id(),
            'user_id'      => $isBroadcast ? null : $request->user_id,
            'title'        => $request->title,
            'message'      => $request->message,
            'is_broadcast' => $isBroadcast,
        ]);

        return redirect()->route('notifications.index')
                         ->with('success', 'Notifikasi berhasil dikirim!');
    }

    // [ADMIN] Lihat semua notifikasi yang pernah dikirim
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $notifications = Notification::with(['recipient', 'reads'])
                                         ->where('sender_id', Auth::id())
                                         ->latest()
                                         ->get();
            return view('notifications.admin_index', compact('notifications'));
        }

        // [USER] Ambil notifikasi yang ditujukan ke user ini atau broadcast
        $notifications = Notification::with(['sender', 'reads'])
                                     ->where(function($q) use ($user) {
                                         $q->where('is_broadcast', true)
                                           ->orWhere('user_id', $user->id);
                                     })
                                     ->latest()
                                     ->get();

        return view('notifications.user_index', compact('notifications'));
    }

    // [USER] Tandai satu notifikasi sebagai sudah dibaca
    public function markRead(Notification $notification)
    {
        $user = Auth::user();
        NotificationRead::firstOrCreate([
            'notification_id' => $notification->id,
            'user_id'         => $user->id,
        ], ['read_at' => now()]);

        return back();
    }

    // [USER] Tandai semua notifikasi sebagai sudah dibaca
    public function markAllRead()
    {
        $user = Auth::user();
        $notifications = Notification::where(function($q) use ($user) {
                $q->where('is_broadcast', true)
                  ->orWhere('user_id', $user->id);
            })
            ->whereDoesntHave('reads', fn($q) => $q->where('user_id', $user->id))
            ->get();

        foreach ($notifications as $notif) {
            NotificationRead::firstOrCreate([
                'notification_id' => $notif->id,
                'user_id'         => $user->id,
            ], ['read_at' => now()]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    // [ADMIN] Hapus notifikasi
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }
}
