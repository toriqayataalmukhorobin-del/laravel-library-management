@extends('layout')
@section('page-title', 'Hasil Scan QR Code')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-qr-code-scan me-2" style="color:var(--accent);"></i>Hasil Scan QR Code</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width:100px;height:100px;background:var(--accent-gradient);font-size:2.5rem;color:white;font-weight:700;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-2">@{{ $user->username }}</p>
                        <span class="badge rounded-pill" style="background:var(--accent-gradient);color:white;">{{ ucfirst($user->role) }}</span>
                    </div>

                    <div class="card mb-4" style="background:var(--bg-primary);border:1px solid var(--border-color);">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3">Informasi Identitas</h6>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 rounded-2" style="background:var(--bg-card);border:1px solid var(--border-color);">
                                        <div class="text-muted small mb-1">Nama Lengkap</div>
                                        <div class="fw-semibold">{{ $user->name }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-2" style="background:var(--bg-card);border:1px solid var(--border-color);">
                                        <div class="text-muted small mb-1">Username</div>
                                        <div class="fw-semibold">{{ $user->username }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-2" style="background:var(--bg-card);border:1px solid var(--border-color);">
                                        <div class="text-muted small mb-1">Email</div>
                                        <div class="fw-semibold">{{ $user->email }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded-2" style="background:var(--bg-card);border:1px solid var(--border-color);">
                                        <div class="text-muted small mb-1">Role</div>
                                        <div class="fw-semibold">{{ ucfirst($user->role) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 rounded-2" style="background:var(--bg-card);border:1px solid var(--border-color);">
                                        <div class="text-muted small mb-1">QR Code</div>
                                        <div class="fw-semibold font-monospace">{{ $user->qr_code }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-success d-flex align-items-center" style="background:rgba(16,185,129,0.1);border-left:3px solid var(--success);color:var(--text-primary);">
                        <i class="bi bi-check-circle-fill me-2" style="color:var(--success);"></i>
                        <div class="small">
                            <strong>QR Code Valid!</strong> Identitas pengguna berhasil diverifikasi.
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            <i class="bi bi-house me-1"></i>Kembali ke Dashboard
                        </a>
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <a href="{{ route('users.index') }}" class="btn btn-primary">
                            <i class="bi bi-people me-1"></i>Kelola User
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
