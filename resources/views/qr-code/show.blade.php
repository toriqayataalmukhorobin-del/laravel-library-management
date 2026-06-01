@extends('layout')
@section('page-title', 'QR Code Saya')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2" style="color:var(--accent);"></i>QR Code Identitas</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:100px;height:100px;background:var(--accent-gradient);font-size:2.5rem;color:white;font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-0">@{{ $user->username }}</p>
                        <span class="badge rounded-pill" style="background:var(--accent-gradient);color:white;">{{ ucfirst($user->role) }}</span>
                    </div>

                    <div class="qr-code-container mb-4 p-4 rounded-3" style="background:var(--bg-primary);border:2px dashed var(--border-color);">
                        <div class="d-flex justify-content-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($user->qr_data) }}" alt="QR Code" style="border:4px solid white;border-radius:8px;">
                        </div>
                        <p class="text-muted small mt-3 mb-0">Scan QR code ini untuk melihat identitas atau reset password</p>
                    </div>

                    <div class="alert alert-info d-flex align-items-start" style="background:rgba(99,102,241,0.1);border-left:3px solid var(--accent);color:var(--text-primary);">
                        <i class="bi bi-info-circle-fill me-2 mt-1" style="color:var(--accent);"></i>
                        <div class="small">
                            <strong>Cara Penggunaan:</strong>
                            <ul class="mb-0 mt-2 ps-3">
                                <li>Gunakan QR code ini sebagai identitas digital Anda</li>
                                <li>Scan untuk melihat informasi identitas</li>
                                <li>Jika lupa password, scan QR code untuk reset password</li>
                                <li><b> code akan berubah setelah reset password untuk keamanan</b></li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <form action="{{ route('qr-code.regenerate') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin membuat QR code baru? QR code lama tidak akan berfungsi lagi.')">
                                <i class="bi bi-arrow-clockwise me-1"></i>Regenerate QR Code
                            </button>
                        </form>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="bi bi-printer me-1"></i>Cetak QR Code
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
