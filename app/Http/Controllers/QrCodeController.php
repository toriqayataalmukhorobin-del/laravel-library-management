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
        $qrData = $request->input('qr_data');

        if (empty($qrData)) {
            return redirect()->back()->with('error', 'QR code data is required');
        }

        try {
            $data = json_decode($qrData, true);

            if (!$data || !isset($data['code'])) {
                return redirect()->back()->with('error', 'Invalid QR code format');
            }

            $user = User::where('qr_code', $data['code'])->first();

            if (!$user) {
                return redirect()->back()->with('error', 'User not found with this QR code');
            }

            return view('qr-code.scan-result', compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to read QR code: ' . $e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        $qrData = $request->input('qr_data');

        if (empty($qrData)) {
            return redirect()->route('login')->with('error', 'QR code data is required');
        }

        try {
            $data = json_decode($qrData, true);

            if (!$data || !isset($data['code'])) {
                return redirect()->route('login')->with('error', 'Invalid QR code format');
            }

            $user = User::where('qr_code', $data['code'])->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'User not found with this QR code');
            }

            // Generate new QR code for security after password reset
            $user->generateQrCode();

            // Redirect to password reset with user email pre-filled
            return redirect()->route('password.request')->with([
                'email' => $user->email,
                'success' => 'QR code verified. Please reset your password.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Failed to verify QR code: ' . $e->getMessage());
        }
    }

    public function regenerate()
    {
        $user = Auth::user();
        $user->generateQrCode();

        return redirect()->route('qr-code.show')->with('success', 'QR code regenerated successfully');
    }
}
