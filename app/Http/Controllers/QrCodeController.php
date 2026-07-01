<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // Generate QR code if user doesn't have one
        if (empty($user->qr_code)) {
            $user->generateQrCode();
        }

        return view('qr-code.show', compact('user'));
    }

    public function scan(Request $request)
    {
        $qrData = trim($request->input('qr_data'));

        if (empty($qrData)) {
            return redirect()->back()->with('error', 'Data QR code wajib diisi');
        }

        try {
            // Cek apakah input berupa JSON
            $data = json_decode($qrData, true);
            
            // Jika JSON valid dan ada key 'code', gunakan itu. Jika tidak, anggap input adalah raw code.
            $code = (is_array($data) && isset($data['code'])) ? $data['code'] : $qrData;

            $user = User::where('qr_code', $code)->first();

            if (!$user) {
                return redirect()->back()->with('error', 'Pengguna dengan QR code ini tidak ditemukan');
            }

            return view('qr-code.scan-result', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses QR code: ' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $qrData = trim($request->input('qr_data'));

        if (empty($qrData)) {
            return redirect()->route('login')->with('error', 'Data QR code wajib diisi');
        }

        try {
            $data = json_decode($qrData, true);
            $code = (is_array($data) && isset($data['code'])) ? $data['code'] : $qrData;

            $user = User::where('qr_code', $code)->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Pengguna dengan QR code ini tidak ditemukan');
            }

            // Generate new QR code for security after password reset
            $user->generateQrCode();

            // Redirect to password reset with user email pre-filled
            return redirect()->route('password.request')->with([
                'email' => $user->email,
                'success' => 'QR code berhasil diverifikasi. Silakan reset password Anda.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal memverifikasi QR code: ' . $e->getMessage());
        }
    }

    public function regenerate()
    {
        $user = Auth::user();
        $user->generateQrCode();

        return redirect()->route('qr-code.show')->with('success', 'QR code regenerated successfully');
    }

    public function scanner()
    {
        return view('admin.scanner');
    }
}
