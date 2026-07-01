@extends('layout')
@section('title', 'Profil Saya')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header border-bottom bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-person-badge text-primary me-2"></i>Informasi Akun</h5>
            </div>
            <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow"
                     style="width:110px;height:110px;background:var(--accent-gradient);font-size:3rem;color:white;font-weight:800;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="text-muted mb-2">@{{ $user->username }}</p>
                <span class="badge rounded-pill" style="background:var(--accent-gradient); color:white; padding: 6px 16px; font-size: 0.85rem;">
                    {{ ucfirst($user->role) }}
                </span>

                <hr class="my-4" style="opacity: 0.1;">
                
                <div class="text-start">
                    <div class="mb-3 p-3 bg-light rounded-3">
                        <label class="text-muted small fw-semibold d-block mb-1">Email Anda</label>
                        <div class="fw-bold text-dark d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary me-2"></i> {{ $user->email }}
                        </div>
                    </div>
                    <div class="mb-3 p-3 bg-light rounded-3">
                        <label class="text-muted small fw-semibold d-block mb-1">Status Akun</label>
                        <div class="fw-bold text-success d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2"></i> Aktif Terverifikasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4 shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header border-bottom bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock text-warning me-2"></i>Keamanan Akun</h5>
            </div>
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-3">Ubah Password</h6>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @if($user->password)
                    <div class="mb-4">
                        <label class="form-label fw-medium text-secondary small">Password Saat Ini</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                            <input type="password" name="current_password" class="form-control border-start-0 bg-light" required>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info border-0 shadow-sm d-flex align-items-center mb-4 rounded-3" style="background: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                        <div>
                            <strong class="d-block">Login via Google</strong>
                            Anda belum memiliki password sistem. Silakan atur password baru di bawah jika ingin login dengan username & password.
                        </div>
                    </div>
                    @endif
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-secondary small">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control border-start-0 bg-light" required minlength="6">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium text-secondary small">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock-fill text-muted"></i></span>
                                <input type="password" name="password_confirmation" class="form-control border-start-0 bg-light" required minlength="6">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">
                            <i class="bi bi-save me-2"></i>Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header border-bottom bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="bi bi-qr-code-scan text-info me-2"></i>Kartu Anggota Digital</h5>
                <a href="{{ route('qr-code.show') }}" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-semibold">Lihat Detail</a>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-4 flex-wrap">
                    <div class="p-2 rounded-4 shadow-sm bg-white" style="border:2px dashed var(--accent);">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ urlencode($user->qr_data) }}"
                             alt="QR Code" style="border-radius:8px; max-width: 130px;">
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-2 fs-5">Kode Identitas: <span class="text-primary">{{ $user->qr_code }}</span></h6>
                        <p class="text-muted small mb-0 lh-lg">QR Code ini menyimpan data <strong>nama, username, email, dan Role</strong> Anda. <br>Gunakan QR ini saat meminjam buku di perpustakaan atau meminta bantuan reset akun kepada admin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
