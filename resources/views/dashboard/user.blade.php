@extends('layout')
@section('page-title', 'Dashboard Saya')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--text-primary);">Halo, {{ Auth::user()->name }} 👋</h2>
        <p class="mb-0" style="color: var(--text-secondary);">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>
</div>

{{-- My Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase mb-2" style="font-size:0.7rem;letter-spacing:1.2px;color:var(--text-muted);font-weight:600;">Sedang Dipinjam</div>
                    <div class="fw-bold" style="font-size:2rem;line-height:1;color:var(--text-primary);">{{ $myActiveBorrowings }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(66,153,225,0.12);">
                    <i class="bi bi-book-fill" style="font-size:1.4rem;color:#4299e1;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase mb-2" style="font-size:0.7rem;letter-spacing:1.2px;color:var(--text-muted);font-weight:600;">Total Riwayat</div>
                    <div class="fw-bold" style="font-size:2rem;line-height:1;color:var(--text-primary);">{{ $myTotalHistory }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(72,187,120,0.12);">
                    <i class="bi bi-clock-history" style="font-size:1.4rem;color:#48bb78;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase mb-2" style="font-size:0.7rem;letter-spacing:1.2px;color:var(--text-muted);font-weight:600;">Terlambat</div>
                    <div class="fw-bold" style="font-size:2rem;line-height:1;color:{{ $myOverdue>0?'var(--danger)':'var(--text-primary)' }};">{{ $myOverdue }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(252,129,129,0.12);">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size:1.4rem;color:#fc8181;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase mb-2" style="font-size:0.7rem;letter-spacing:1.2px;color:var(--text-muted);font-weight:600;">Total Denda</div>
                    <div class="fw-bold" style="font-size:1.4rem;line-height:1;color:{{ $myTotalFine>0?'var(--danger)':'var(--text-primary)' }};">Rp {{ number_format($myTotalFine,0,',','.') }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(159,122,234,0.12);">
                    <i class="bi bi-cash-stack" style="font-size:1.4rem;color:#9f7aea;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">

    {{-- Recent Borrowings --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between align-items-center p-4 pb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2" style="color:var(--accent);"></i>Peminjaman Terakhir</h6>
                    <a href="{{ route('borrowings.index') }}" class="btn btn-sm rounded-pill px-3" style="background:rgba(66,153,225,0.1);color:var(--accent);font-size:0.8rem;">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="color:var(--text-primary)">
                        <thead>
                            <tr>
                                <th class="ps-4">Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Batas Kembali</th>
                                <th>Status</th>
                                <th>Denda</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myRecentBorrowings as $b)
                            <tr>
                                <td class="ps-4 fw-medium">{{ $b->book->title ?? 'Buku Dihapus' }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}</td>
                                <td>
                                    @php $ret = \Carbon\Carbon::parse($b->return_date); $late = $ret->isPast() && $b->status=='borrowed'; @endphp
                                    <span class="{{ $late?'text-danger fw-bold':'' }}">{{ $ret->format('d M Y') }} @if($late)<i class="bi bi-exclamation-circle"></i>@endif</span>
                                </td>
                                <td>
                                    @if($b->status=='borrowed')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $currentFine = $b->fine;
                                        if ($b->status === 'borrowed' && \Carbon\Carbon::parse($b->return_date)->isPast()) {
                                            $daysOver = \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($b->return_date));
                                            $currentFine = $daysOver * 1000;
                                        }
                                    @endphp
                                    @if($currentFine > 0)
                                        <span class="text-danger fw-bold">Rp {{ number_format($currentFine,0,',','.') }}</span>
                                    @else
                                        <span style="color:var(--text-muted);">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4" style="color:var(--text-muted);">Belum ada peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
