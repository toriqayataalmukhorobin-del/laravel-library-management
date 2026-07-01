@extends('layout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4 px-3">
    <div class="w-100" style="max-width: 480px;">
        <div class="card shadow-lg border-0 login-card" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header py-4 text-white text-center" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4299e1 100%);">
                <div class="mb-3">
                    <i class="bi bi-qr-code-scan" style="font-size: 2.5rem; display: block;"></i>
                </div>
                <h4 class="mb-0 fw-bold" style="font-size: 1.25rem;">Reset Password</h4>
                <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 0.85rem;">Gunakan QR Code Anda untuk membuat password baru</p>
            </div>
            <div class="card-body p-4 p-sm-5">
                @if (session('error'))
                    <div class="alert alert-danger border-0 rounded-3 d-flex align-items-start" style="background: #fee2e2; color: #991b1b;">
                        <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                        <div class="flex-grow-1">{{ session('error') }}</div>
                    </div>
                @endif
                
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 d-flex align-items-start" style="background: #fee2e2; color: #991b1b;">
                        <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                        <div class="flex-grow-1">
                            <ul class="mb-0 ps-2" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li class="mb-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" id="resetForm">
                    @csrf
                    <div class="mb-4">
                        <label for="qr_data" class="form-label fw-semibold" style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="bi bi-qr-code me-2"></i>Data QR Code / Kode
                        </label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 border-end-0" style="background: var(--bg-primary); border-color: var(--border-color);">
                                <i class="bi bi-upc-scan" style="color: var(--text-muted);"></i>
                            </span>
                            <input type="text" name="qr_data" class="form-control form-control-lg rounded-end-4 border-start-0" id="qr_data"
                                   required placeholder="Paste JSON QR atau ketik kode QR"
                                   style="background: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary); padding: 0.75rem 1rem;">
                        </div>
                        <div class="form-text" style="font-size: 0.8rem;">Gunakan hasil scan dari gambar QR Code Anda.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold" style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="bi bi-lock me-2"></i>Password Baru
                        </label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 border-end-0" style="background: var(--bg-primary); border-color: var(--border-color);">
                                <i class="bi bi-key" style="color: var(--text-muted);"></i>
                            </span>
                            <input type="password" name="password" class="form-control form-control-lg rounded-end-4 border-start-0" id="password"
                                   required placeholder="Minimal 6 karakter"
                                   style="background: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary); padding: 0.75rem 1rem;">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold" style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="bi bi-check2-circle me-2"></i>Konfirmasi Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-4 border-end-0" style="background: var(--bg-primary); border-color: var(--border-color);">
                                <i class="bi bi-check-all" style="color: var(--text-muted);"></i>
                            </span>
                            <input type="password" name="password_confirmation" class="form-control form-control-lg rounded-end-4 border-start-0" id="password_confirmation"
                                   required placeholder="Ulangi password baru"
                                   style="background: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary); padding: 0.75rem 1rem;">
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary btn-lg rounded-4 fw-semibold" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border: none; padding: 0.875rem; font-size: 1rem; box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3); transition: all 0.3s ease;">
                            <i class="bi bi-save me-2"></i>Simpan Password Baru
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <a href="{{ url('/login') }}" class="text-decoration-none" style="color: var(--text-muted); font-size: 0.9rem;">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Halaman Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .input-group-text:focus-within {
    border-color: var(--accent) !important;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15) !important;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(30, 60, 114, 0.4) !important;
}

@media (max-width: 576px) {
    .card-body { padding: 1.5rem !important; }
}
</style>

<script>
document.getElementById('resetForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i>Memproses...';
});
</script>
@endsection
