@extends('layout')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="card-header py-4 text-white text-center" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <i class="bi bi-person-plus-fill fs-1 d-block mb-2"></i>
                <h4 class="mb-0 fw-bold">Daftar Akun Baru</h4>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-medium"><i class="bi bi-card-text me-1"></i> Nama Lengkap</label>
                        <input type="text" name="name" class="form-control rounded-3" id="name"
                               value="{{ old('name') }}" required autofocus placeholder="Nama lengkap Anda">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label fw-medium"><i class="bi bi-person me-1"></i> Username</label>
                        <div class="input-group">
                            <span class="input-group-text rounded-start-3 border-end-0 bg-light">@</span>
                            <input type="text" name="username" class="form-control rounded-end-3 border-start-0" id="username"
                                   value="{{ old('username') }}" required placeholder="username_anda (huruf, angka, _ , -)">
                        </div>
                        <div class="form-text">Hanya huruf, angka, underscore (_) dan strip (-) yang diperbolehkan.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium"><i class="bi bi-envelope me-1"></i> Alamat Email</label>
                        <input type="email" name="email" class="form-control rounded-3" id="email"
                               value="{{ old('email') }}" required placeholder="email@contoh.com">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-medium"><i class="bi bi-lock me-1"></i> Password</label>
                        <input type="password" name="password" class="form-control rounded-3" id="password"
                               required placeholder="Minimal 6 karakter">
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label fw-medium"><i class="bi bi-lock-fill me-1"></i> Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control rounded-3" id="password_confirmation"
                               required placeholder="Ulangi password Anda">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg rounded-3">
                            <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                        </button>
                    </div>
                </form>
                <div class="text-center mt-4">
                    <p class="text-muted">Sudah punya akun? <a href="{{ url('/login') }}" class="fw-semibold">Login disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
