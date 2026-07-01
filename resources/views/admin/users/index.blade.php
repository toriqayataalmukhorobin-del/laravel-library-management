@extends('layout')
@section('page-title', 'Data User Terdaftar')

@section('content')
<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-people-fill me-2 text-primary"></i>Data User Terdaftar</h2>
        <p class="text-muted mb-0">Total: <strong>{{ $users->count() }}</strong> pengguna aktif</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4">
        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
        <span>{{ session('error') }}</span>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Daftar Semua Pengguna</h5>
        <div class="position-relative">
            <i class="bi bi-search position-absolute" style="top: 50%; left: 12px; transform: translateY(-50%); color: #6c757d;"></i>
            <input type="text" id="userSearch" class="form-control ps-5 rounded-pill shadow-sm border-0 bg-light" placeholder="Cari nama/email...">
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Total Pinjam</th>
                        <th class="text-center">Sedang Pinjam</th>
                        <th class="text-center">Total Denda</th>
                        <th>Bergabung</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse($users as $index => $user)
                    <tr class="user-row">
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3"
                                     style="width: 40px; height: 40px; flex-shrink: 0;">
                                    <span class="fw-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <span class="fw-medium user-name">{{ $user->name }}</span>
                                    <div class="text-muted small">@{{ $user->username }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-muted user-email">{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="badge bg-secondary rounded-pill">{{ $user->borrowings_count }}</span>
                        </td>
                        <td class="text-center">
                            @if($user->active_borrowings_count > 0)
                                <span class="badge bg-warning text-dark rounded-pill">{{ $user->active_borrowings_count }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($user->total_fine > 0)
                                <span class="badge bg-danger rounded-pill">Rp {{ number_format($user->total_fine, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted small">—</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-center">
                            @if($user->active_borrowings_count > 0)
                                <span class="badge bg-warning text-dark"><i class="bi bi-book me-1"></i>Meminjam</span>
                            @else
                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($user->active_borrowings_count == 0)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus pengguna {{ $user->name }}? Aksi ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-people display-4 d-block mb-3"></i>
                            Belum ada pengguna yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('userSearch');
    const rows = document.querySelectorAll('.user-row');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            rows.forEach(row => {
                const name = row.querySelector('.user-name').textContent.toLowerCase();
                const email = row.querySelector('.user-email').textContent.toLowerCase();
                row.style.display = (name.includes(filter) || email.includes(filter)) ? '' : 'none';
            });
        });
    }
});
</script>
@endsection
