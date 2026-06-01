@extends('layout')
@section('page-title', 'Admin Dashboard')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: var(--text-primary);">Selamat Datang 👋</h2>
        <p class="mb-0" style="color: var(--text-secondary);">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase fw-600 mb-2" style="font-size:0.7rem;letter-spacing:1px;color:var(--text-muted);">Total Buku</div>
                    <div class="fw-bold" style="font-size:1.8rem;line-height:1;color:var(--text-primary);">{{ $totalBooks }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(99,102,241,0.12);">
                    <i class="bi bi-journal-text" style="font-size:1.2rem;color:var(--accent);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase fw-600 mb-2" style="font-size:0.7rem;letter-spacing:1px;color:var(--text-muted);">Total User</div>
                    <div class="fw-bold" style="font-size:1.8rem;line-height:1;color:var(--text-primary);">{{ $totalUsers }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(16,185,129,0.12);">
                    <i class="bi bi-people-fill" style="font-size:1.2rem;color:var(--success);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase fw-600 mb-2" style="font-size:0.7rem;letter-spacing:1px;color:var(--text-muted);">Dipinjam</div>
                    <div class="fw-bold" style="font-size:1.8rem;line-height:1;color:var(--text-primary);">{{ $activeBorrowings }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(245,158,11,0.12);">
                    <i class="bi bi-book-fill" style="font-size:1.2rem;color:var(--warning);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="text-uppercase fw-600 mb-2" style="font-size:0.7rem;letter-spacing:1px;color:var(--text-muted);">Terlambat</div>
                    <div class="fw-bold" style="font-size:1.8rem;line-height:1;color:var(--danger);">{{ $overdueBorrowings }}</div>
                </div>
                <div class="rounded-3 p-2" style="background:rgba(239,68,68,0.12);">
                    <i class="bi bi-exclamation-triangle-fill" style="font-size:1.2rem;color:var(--danger);"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Smart Stats Row --}}
<div class="row g-3 mb-4">

    {{-- Monthly Chart --}}
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-line-fill me-2" style="color:var(--accent);"></i>Grafik Peminjaman Bulanan</h6>
                    <span class="badge rounded-pill" style="background:rgba(99,102,241,0.12);color:var(--accent);font-size:0.75rem;">6 Bulan Terakhir</span>
                </div>
                <canvas id="monthlyChart" height="180"></canvas>
            </div>
        </div>
    </div>

    {{-- Popular Books --}}
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-fire me-2" style="color:var(--warning);"></i>Buku Paling Populer</h6>
                @forelse($popularBooks as $i => $book)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="fw-bold rounded-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width:28px;height:28px;font-size:0.75rem;background:{{ $i===0?'var(--accent-gradient)':'rgba(99,102,241,0.1)' }};color:{{ $i===0?'white':'var(--accent)' }};">{{ $i+1 }}</div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-semibold text-truncate" style="font-size:0.85rem;color:var(--text-primary);">{{ $book->title }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $book->borrowings_count }} kali dipinjam</div>
                    </div>
                    <div class="text-end">
                        <div style="width:60px;height:6px;background:var(--border-color);border-radius:3px;">
                            <div style="width:{{ $popularBooks->first()->borrowings_count > 0 ? ($book->borrowings_count/$popularBooks->first()->borrowings_count)*100 : 0 }}%;height:100%;background:var(--accent-gradient);border-radius:3px;"></div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted small">Belum ada data peminjaman.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- Active Users --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-person-fill-check me-2" style="color:var(--success);"></i>User Paling Aktif</h6>
                @forelse($activeUsers as $i => $user)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width:34px;height:34px;background:var(--accent-gradient);color:white;font-size:0.8rem;">{{ strtoupper(substr($user->name,0,1)) }}</div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size:0.85rem;color:var(--text-primary);">{{ $user->name }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $user->borrowings_count }} peminjaman</div>
                    </div>
                    <span class="badge rounded-pill" style="background:rgba(16,185,129,0.12);color:var(--success);">Aktif</span>
                </div>
                @empty
                <p class="text-muted small">Belum ada data.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Category Stats --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-tags-fill me-2" style="color:#8b5cf6;"></i>Kategori Buku</h6>
                @php
                    $catColors = ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4'];
                    $catTotal = $categoryStats->sum('books_count');
                @endphp
                @forelse($categoryStats as $i => $cat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">{{ $cat->name }}</span>
                        <span style="font-size:0.75rem;color:var(--text-muted);">{{ $cat->books_count }} buku</span>
                    </div>
                    <div style="height:6px;background:var(--border-color);border-radius:3px;">
                        <div style="width:{{ $catTotal>0?($cat->books_count/$catTotal)*100:0 }}%;height:100%;background:{{ $catColors[$i%count($catColors)] }};border-radius:3px;transition:width 0.8s ease;"></div>
                    </div>
                </div>
                @empty
                <p class="text-muted small">Tambahkan kategori pada data buku.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Recent Borrowings --}}
<div class="card">
    <div class="card-body p-0">
        <div class="d-flex justify-content-between align-items-center p-4 pb-3">
            <h6 class="fw-bold mb-0"><i class="bi bi-clock-history me-2" style="color:var(--accent);"></i>Peminjaman Terbaru</h6>
            <a href="{{ route('borrowings.index') }}" class="btn btn-sm rounded-pill px-3" style="background:rgba(99,102,241,0.1);color:var(--accent);font-size:0.8rem;">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBorrowings as $borrow)
                    <tr>
                        <td class="ps-4 fw-medium">{{ $borrow->borrower_display_name }}</td>
                        <td>{{ $borrow->book->title ?? 'Buku Dihapus' }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}</td>
                        <td>
                            @php $ret = \Carbon\Carbon::parse($borrow->return_date); $late = $ret->isPast() && $borrow->status=='borrowed'; @endphp
                            <span class="{{ $late?'text-danger fw-bold':'' }}">{{ $ret->format('d M Y') }} @if($late)<i class="bi bi-exclamation-circle ms-1"></i>@endif</span>
                        </td>
                        <td>
                            @if($borrow->status=='borrowed')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4" style="color:var(--text-muted);">Belum ada aktivitas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const gridColor = isDark ? 'rgba(255,255,255,0.08)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#94a3b8' : '#718096';

    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const labels = @json(array_column($monthlyData, 'label'));
    const data   = @json(array_column($monthlyData, 'count'));

    const gradient = ctx.createLinearGradient(0, 0, 0, 220);
    gradient.addColorStop(0, 'rgba(99,102,241,0.35)');
    gradient.addColorStop(1, 'rgba(99,102,241,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Peminjaman',
                data,
                borderColor: '#6366f1',
                borderWidth: 2.5,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: isDark ? '#1e293b' : '#fff',
                    titleColor: isDark ? '#f1f5f9' : '#1a202c',
                    bodyColor: '#6366f1',
                    borderColor: 'rgba(99,102,241,0.2)',
                    borderWidth: 1,
                    callbacks: { label: ctx => ` ${ctx.parsed.y} peminjaman` }
                }
            },
            scales: {
                x: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 }, stepSize: 1, beginAtZero: true } }
            }
        }
    });
})();
</script>
@endpush
