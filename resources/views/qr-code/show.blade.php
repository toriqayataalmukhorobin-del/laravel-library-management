@extends('layout')
@section('page-title', 'QR Code Saya')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
        <div class="row g-4">
            {{-- QR Code Card --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2" style="color:var(--accent);"></i>QR Code Identitas Saya</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width:80px;height:80px;background:var(--accent-gradient);font-size:2rem;color:white;font-weight:700;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                            <p class="text-muted mb-1 small">@{{ $user->username }}</p>
                            <span class="badge rounded-pill" style="background:var(--accent-gradient);color:white;">{{ ucfirst($user->role) }}</span>
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background:var(--bg-primary);border:2px dashed var(--border-color);">
                            <div class="d-flex justify-content-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode($user->qr_data) }}"
                                     alt="QR Code {{ $user->name }}"
                                     id="qrImage"
                                     style="border:4px solid white;border-radius:8px;max-width:100%;">
                            </div>
                            <p class="text-muted small mt-2 mb-0">
                                <i class="bi bi-shield-check me-1"></i>
                                Kode: <code class="small">{{ $user->qr_code }}</code>
                            </p>
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <form action="{{ route('qr-code.regenerate') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm"
                                        onclick="return confirm('QR code lama tidak akan berfungsi lagi setelah ini. Lanjutkan?')">
                                    <i class="bi bi-arrow-clockwise me-1"></i>Regenerate
                                </button>
                            </form>
                            <button onclick="window.print()" class="btn btn-primary btn-sm">
                                <i class="bi bi-printer me-1"></i>Cetak
                            </button>
                            <a href="https://api.qrserver.com/v1/create-qr-code/?size=400x400&data={{ urlencode($user->qr_data) }}"
                               download="qr-{{ $user->username }}.png" class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="bi bi-download me-1"></i>Unduh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info & Scan Card --}}
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-info-circle me-2" style="color:var(--accent);"></i>Cara Penggunaan</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-1-circle-fill text-primary mt-1 flex-shrink-0"></i>
                                <span class="small">Gunakan QR code ini sebagai identitas digital Anda di perpustakaan.</span>
                            </li>
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-2-circle-fill text-primary mt-1 flex-shrink-0"></i>
                                <span class="small">Admin dapat menscan QR code untuk melihat identitas Anda.</span>
                            </li>
                            <li class="d-flex gap-2 mb-2">
                                <i class="bi bi-3-circle-fill text-primary mt-1 flex-shrink-0"></i>
                                <span class="small">QR code berubah otomatis saat Anda klik <b>Regenerate</b> untuk keamanan.</span>
                            </li>
                            <li class="d-flex gap-2">
                                <i class="bi bi-4-circle-fill text-primary mt-1 flex-shrink-0"></i>
                                <span class="small">Cetak atau unduh untuk disimpan secara offline.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                @if(auth()->user()->isAdmin())
                {{-- Admin: Scan QR --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-camera me-2" style="color:var(--accent);"></i>Scan QR Code Pengguna</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Masukkan data QR code (JSON) atau kode QR untuk memverifikasi identitas pengguna.</p>
                        <form action="{{ route('qr-code.scan') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Data QR Code / Kode</label>
                                <textarea name="qr_data" class="form-control" rows="3"
                                          placeholder='{"id":1,"code":"QR-ABC123","name":"Nama User","username":"user1","role":"user"}'
                                          required></textarea>
                                <div class="form-text">Paste hasil scan QR code JSON di sini</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-qr-code-scan me-1"></i>Verifikasi QR Code
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .sidebar, .top-bar, .mobile-menu-btn, form, .btn, .page-header { display: none !important; }
    .main-wrapper { margin-left: 0 !important; }
    .content-area { padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
    #qrImage { width: 250px !important; height: 250px !important; }
}
</style>
@endpush
@endsection
