@extends('layout')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 py-4 px-3" style="position: relative; overflow: hidden; background: linear-gradient(135deg, #f6f8fb 0%, #e5ebf4 100%);">
    
    <!-- Decorative Background Shapes -->
    <div style="position: absolute; top: -100px; left: -100px; width: 400px; height: 400px; background: rgba(99, 102, 241, 0.15); border-radius: 50%; filter: blur(50px);"></div>
    <div style="position: absolute; bottom: -150px; right: -50px; width: 500px; height: 500px; background: rgba(16, 185, 129, 0.1); border-radius: 50%; filter: blur(60px);"></div>

    <div class="w-100" style="max-width: 520px; position: relative; z-index: 10;">
        <div class="card shadow-lg border-0 register-card" style="border-radius: 24px; overflow: hidden; transform: translateY(0); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(20px);">
            <div class="card-header py-5 text-white text-center position-relative" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-bottom: none;">
                <div class="mb-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white text-success rounded-circle shadow-sm" style="width: 70px; height: 70px;">
                        <i class="bi bi-person-plus-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold" style="letter-spacing: -0.5px;">Daftar Akun Baru</h3>
                <p class="mb-0 mt-2 text-white-50" style="font-size: 0.95rem;">Bergabung dengan PerpustakaanKU</p>
            </div>
            
            <div class="card-body p-4 p-sm-5">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 d-flex align-items-start shadow-sm mb-4" style="background: #fee2e2; color: #991b1b;">
                        <i class="bi bi-exclamation-triangle-fill me-2 mt-1" style="font-size: 1.1rem;"></i>
                        <div class="flex-grow-1">
                            <ul class="mb-0 ps-2" style="list-style: none;">
                                @foreach ($errors->all() as $error)
                                    <li class="mb-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="text-center mb-4">
                    <div class="alert alert-warning border-0 rounded-4 p-3 mb-4 d-flex flex-column align-items-center justify-content-center shadow-sm" style="background: #fffbeb; color: #b45309; font-size: 0.95rem; line-height: 1.6;">
                        <i class="bi bi-shield-lock-fill fs-3 mb-2 text-warning"></i>
                        <span>Demi keamanan dan keaslian data, pendaftaran akun baru wajib menggunakan <strong>akun Google asli yang aktif</strong>. Pendaftaran manual menggunakan email asal-asalan dinonaktifkan.</span>
                    </div>
                </div>

                <div class="d-grid gap-3">
                    <a href="{{ route('google.login') }}" class="btn btn-outline-dark btn-lg rounded-4 fw-semibold d-flex align-items-center justify-content-center gap-3 google-btn" style="padding: 1rem; border-width: 2px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
                        Daftar dengan Google
                    </a>
                </div>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Sudah punya akun? <a href="{{ url('/login') }}" class="fw-bold text-success text-decoration-none">Login disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.register-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.1) !important;
}

.google-btn {
    transition: all 0.3s ease;
    background: white;
    border: 2px solid #e2e8f0;
    color: #475569;
}

.google-btn:hover {
    background: #f8fafc;
    border-color: #11998e;
    color: #11998e;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(17, 153, 142, 0.15);
}
</style>
@endsection
