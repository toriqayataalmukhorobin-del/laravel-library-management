<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Coba login dengan username
        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users|alpha_dash',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        event(new \Illuminate\Auth\Events\Registered($user));

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showQrResetForm()
    {
        return view('auth.reset-password');
    }

    public function resetPasswordViaQr(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $qrData = trim($request->qr_data);
        
        try {
            $data = json_decode($qrData, true);
            $code = (is_array($data) && isset($data['code'])) ? $data['code'] : $qrData;

            $user = User::where('qr_code', $code)->first();

            if (!$user) {
                return back()->with('error', 'QR code tidak valid atau pengguna tidak ditemukan.');
            }

            // Update password
            $user->password = Hash::make($request->password);
            
            // Regenerate QR code for security
            $user->generateQrCode();

            return redirect('/login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses QR code.');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Jika user sudah ada, langsung login
                if (!$user->google_id || !$user->email_verified_at) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'email_verified_at' => $user->email_verified_at ?? now()
                    ]);
                }
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }

            // Jika user belum ada, simpan data di session dan redirect ke form username/password
            session([
                'google_registration' => [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                ]
            ]);

            return redirect('/register/complete');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login dengan Google: ' . $e->getMessage());
        }
    }

    public function showCompleteRegistrationForm()
    {
        if (!session('google_registration')) {
            return redirect('/register')->with('error', 'Silakan daftar dengan Google terlebih dahulu.');
        }

        return view('auth.register-complete');
    }

    public function completeRegistration(Request $request)
    {
        if (!session('google_registration')) {
            return redirect('/register')->with('error', 'Sesi registrasi tidak valid. Silakan daftar ulang.');
        }

        $googleData = session('google_registration');

        $request->validate([
            'username' => 'required|string|max:50|unique:users|alpha_dash',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $googleData['name'],
            'username' => $request->username,
            'email' => $googleData['email'],
            'google_id' => $googleData['google_id'],
            'password' => Hash::make($request->password),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Hapus session
        session()->forget('google_registration');

        event(new \Illuminate\Auth\Events\Registered($user));
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registrasi berhasil!');
    }
}

