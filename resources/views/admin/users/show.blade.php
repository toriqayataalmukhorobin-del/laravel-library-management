@extends('layout')
@section('page-title', 'Detail Pengguna — ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-person-fill me-2 text-primary"></i>Detail Pengguna</h2>
        <p class="text-muted mb-0">Informasi lengkap dan riwayat peminjaman</p>
    </div>
    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                     style="width:90px;height:90px;background:var(--accent-gradient);font-size:2.2rem;color:white;font-weight:700;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <p class="text-muted small mb-1">@{{ $user->username }}</p>
                <span class="badge rounded-pill" style="background:var(--accent-gradient);color:white;">{{ ucfirst($user->role) }}</span>

                <hr class="my-3">

                <div class="text-start">
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-envelope text-muted"></i>
                        <span class="small">{{ $user->email }}</span>
                    </div>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <i class="bi bi-calendar text-muted"></i>
                        <span class="small">Bergabung {{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    @if($user->qr_code)
                    <div class="mb-2 d-flex align-items-start gap-2">
                        <i class="bi bi-qr-code text-muted mt-1"></i>
                        <span class="small font-monospace text-break">{{ $user->qr_code }}</span>
                    </div>
                    @endif
                </div>

                <hr class="my-3">

                <div class="row g-2 text-center">
                    <div class="col-4">
                        <div class="p-2 rounded-2" style="background:var(--bg-primary);">
                            <div class="fw-bold fs-5 text-primary">{{ $borrowings->count() }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">Total</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-2" style="background:var(--bg-primary);">
                            <div class="fw-bold fs-5 text-warning">{{ $activeBorrowings }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">Aktif</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="p-2 rounded-2" style="background:var(--bg-primary);">
                            <div class="fw-bold fs-5 text-danger">{{ $borrowings->where('status', 'returned')->count() }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">Selesai</div>
                        </div>
                    </div>
                </div>

                @if($totalFine > 0)
                <div class="alert mt-3 mb-0" style="background:rgba(239,68,68,0.1);border-left:3px solid var(--danger);">
                    <div class="small fw-semibold text-danger">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Total Denda: Rp {{ number_format($totalFine, 0, ',', '.') }}
                    </div>
                </div>
                @endif

                @if($activeBorrowings == 0)
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="mt-3"
                      onsubmit="return confirm('Hapus pengguna ini secara permanen?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="bi bi-trash me-1"></i>Hapus Pengguna
                    </button>
                </form>
                @else
                <div class="alert mt-3 mb-0" style="background:rgba(245,158,11,0.1);border-left:3px solid var(--warning);">
                    <div class="small text-warning">
                        <i class="bi bi-info-circle me-1"></i>
                        Tidak dapat dihapus — masih ada peminjaman aktif.
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Borrowing History --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2" style="color:var(--accent);"></i>Riwayat Peminjaman</h6>
                <span class="badge" style="background:var(--accent-gradient);color:white;">{{ $borrowings->count() }} Total</span>
            </div>
            <div class="card-body p-0">
                @if($borrowings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $b)
                            <tr>
                                <td class="ps-3">
                                    <span class="fw-medium small">{{ $b->book->title ?? '(Buku dihapus)' }}</span>
                                </td>
                                <td class="text-muted small">{{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}</td>
                                <td class="text-muted small">{{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}</td>
                                <td class="text-center">
                                    @if($b->status === 'borrowed')
                                        @if(\Carbon\Carbon::parse($b->return_date)->isPast())
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Dipinjam</span>
                                        @endif
                                    @else
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($b->fine > 0)
                                        <span class="badge bg-danger">Rp {{ number_format($b->fine, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-book display-4 d-block mb-3 opacity-25"></i>
                    <p>Pengguna ini belum pernah meminjam buku.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
