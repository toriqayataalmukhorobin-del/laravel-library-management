@extends('layout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4 px-3">
    <div class="w-100" style="max-width: 480px;">
        <div class="card shadow-lg border-0 login-card" style="border-radius: 20px; overflow: hidden; transform: translateY(0); transition: all 0.3s ease;">
            <div class="card-header py-5 text-white text-center" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4299e1 100%);">
                <div class="mb-3">
                    <i class="bi bi-book-half" style="font-size: 3rem; display: block;"></i>
                </div>
                <h4 class="mb-0 fw-bold" style="font-size: 1.5rem; letter-spacing: -0.5px;">Masuk ke PerpustakaanKU</h4>
                <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 0.9rem;">Sistem Manajemen Perpustakaan</p>
            </div>
            <div class="card-body p-4 p-sm-5">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 d-flex align-items-start" style="background: #fee2e2; color: #991b1b;">
                        <i class="bi bi-exclamation-circle-fill me-2 mt-1" style="font-size: 1.2rem;"></i>
                        <div class="flex-grow-1">
                            <ul class="mb-0 ps-2" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li class="mb-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" id="loginForm">
                    @csrf
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold" style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="bi bi-person me-2"></i>Username
                        </label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 border-end-0" style="background: var(--bg-primary); border-color: var(--border-color);">
                                <i class="bi bi-person" style="color: var(--text-muted);"></i>
                            </span>
                            <input type="text" name="username" class="form-control form-control-lg rounded-end-4 border-start-0" id="username"
                                   value="{{ old('username') }}" required autofocus placeholder="Masukkan username Anda"
                                   style="background: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary); padding: 0.75rem 1rem;">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold" style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="bi bi-lock me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 border-end-0" style="background: var(--bg-primary); border-color: var(--border-color);">
                                <i class="bi bi-lock" style="color: var(--text-muted);"></i>
                            </span>
                            <input type="password" name="password" class="form-control form-control-lg rounded-end-4 border-start-0" id="password"
                                   required placeholder="Masukkan password Anda"
                                   style="background: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary); padding: 0.75rem 1rem;">
                            <button type="button" class="input-group-text rounded-end-4 border-start-0" style="background: var(--bg-primary); border-color: var(--border-color); cursor: pointer;" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-4 fw-semibold" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none; padding: 0.875rem; font-size: 1rem; box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3); transition: all 0.3s ease;">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                        </button>
                        <a href="{{ route('google.login') }}" class="btn btn-outline-danger btn-lg rounded-4 fw-semibold" style="padding: 0.875rem; font-size: 1rem; transition: all 0.3s ease;">
                            <i class="bi bi-google me-2"></i> Masuk dengan Google
                        </a>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: var(--text-muted); font-size: 0.85rem;">
                            <i class="bi bi-qr-code-scan me-1"></i>Lupa Password via QR Code
                        </a>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="mb-0" style="color: var(--text-muted); font-size: 0.9rem;">
                        Belum punya akun? 
                        <a href="{{ url('/register') }}" class="fw-semibold text-decoration-none" style="color: var(--accent);">Daftar disini</a>
                    </p>
                </div>
            </div>
        </div>
        <p class="text-center mt-4 mb-0" style="color: var(--text-muted); font-size: 0.85rem;">
            © 2024 PerpustakaanKU. All rights reserved.
        </p>
    </div>
</div>

<style>
.login-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}

.form-control:focus, .input-group-text:focus-within {
    border-color: var(--accent) !important;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15) !important;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(30, 60, 114, 0.4) !important;
}

.btn-primary:active {
    transform: translateY(0);
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .card-header {
        padding: 2rem 1rem !important;
    }
    
    .card-header h4 {
        font-size: 1.25rem !important;
    }
}

@media (max-width: 400px) {
    .card-body {
        padding: 1.25rem !important;
    }
}
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}

document.getElementById('loginForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Memproses...';
});
</script>
@endsection
