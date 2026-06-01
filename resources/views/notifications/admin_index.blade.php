@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-send-fill me-2 text-primary"></i>Riwayat Notifikasi Terkirim</h2>
        <p class="text-muted mb-0">Semua notifikasi yang telah Anda kirim</p>
    </div>
    <a href="{{ route('notifications.create') }}" class="btn btn-primary rounded-pill shadow-sm">
        <i class="bi bi-plus-lg me-1"></i> Kirim Notifikasi Baru
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Judul</th>
                        <th>Penerima</th>
                        <th>Terbaca</th>
                        <th>Waktu Kirim</th>
                        <th class="text-center" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $index => $notif)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            <p class="fw-semibold mb-0">{{ $notif->title }}</p>
                            <small class="text-muted">{{ Str::limit($notif->message, 60) }}</small>
                        </td>
                        <td>
                            @if($notif->is_broadcast)
                                <span class="badge bg-primary rounded-pill"><i class="bi bi-people-fill me-1"></i>Semua User</span>
                            @else
                                <span class="badge bg-info text-dark rounded-pill"><i class="bi bi-person me-1"></i>{{ $notif->recipient->name ?? 'User Dihapus' }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $notif->reads->count() > 0 ? 'success' : 'secondary' }} rounded-pill">
                                {{ $notif->reads->count() }} orang membaca
                            </span>
                        </td>
                        <td class="text-muted small">{{ $notif->created_at->diffForHumans() }}</td>
                        <td class="text-center">
                            <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill"
                                        onclick="return confirm('Hapus notifikasi ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-bell-slash display-4 d-block mb-3"></i>
                            Belum ada notifikasi yang dikirim.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
