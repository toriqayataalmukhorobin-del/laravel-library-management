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
                        <i class="bi bi-check-circle-fill" style="font-size: 2rem;"></i>
                    </div>
                </div>
                <h3 class="mb-0 fw-bold" style="letter-spacing: -0.5px;">Email Terverifikasi!</h3>
                <p class="mb-0 mt-2 text-white-50" style="font-size: 0.95rem;">Lengkapi data akun Anda</p>
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

                @if (session('google_registration'))
                    <div class="alert alert-success border-0 rounded-4 p-3 mb-4 d-flex align-items-center shadow-sm" style="background: #d1fae5; color: #065f46;">
                        <i class="bi bi-envelope-check-fill fs-4 me-3 text-success"></i>
                        <div>
                            <small class="text-muted d-block">Email terverifikasi:</small>
                            <strong>{{ session('google_registration.email') }}</strong>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ url('/register/complete') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="username" class="form-label fw-semibold" style="color: #475569;">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #e2e8f0;">
                                <i class="bi bi-person" style="color: #64748b;"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0 ps-0" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}"
                                   placeholder="Masukkan username"
                                   required
                                   autofocus
                                   style="border-color: #e2e8f0; padding-left: 1rem;">
                        </div>
                        @error('username')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold" style="color: #475569;">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #e2e8f0;">
                                <i class="bi bi-lock" style="color: #64748b;"></i>
                            </span>
                            <input type="password" 
                                   class="form-control border-start-0 ps-0" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Masukkan password (minimal 6 karakter)"
                                   required
                                   style="border-color: #e2e8f0; padding-left: 1rem;">
                        </div>
                        @error('password')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-semibold" style="color: #475569;">Konfirmasi Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #e2e8f0;">
                                <i class="bi bi-lock-fill" style="color: #64748b;"></i>
                            </span>
                            <input type="password" 
                                   class="form-control border-start-0 ps-0" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Ulangi password"
                                   required
                                   style="border-color: #e2e8f0; padding-left: 1rem;">
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-lg rounded-4 fw-bold text-white" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; padding: 0.875rem; box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);">
                            <i class="bi bi-check-lg me-2"></i>Selesaikan Pendaftaran
                        </button>
                    </div>
                </form>
                
                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Email sudah terverifikasi dengan Google</p>
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

.form-control:focus {
    border-color: #11998e !important;
    box-shadow: 0 0 0 0.2rem rgba(17, 153, 142, 0.15) !important;
}

.input-group-text {
    border-radius: 0.5rem 0 0 0.5rem !important;
}

.form-control {
    border-radius: 0 0.5rem 0.5rem 0 !important;
}
</style>
@endsection
