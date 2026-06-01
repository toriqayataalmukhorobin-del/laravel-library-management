@extends('layout')
@section('page-title', 'Kelola Perpustakaan')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Kelola Perpustakaan</h2>
        <a href="{{ route('libraries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Perpustakaan
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Koordinat</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($libraries as $library)
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $library->name }}</div>
                                @if($library->email)
                                <div class="text-muted small">{{ $library->email }}</div>
                                @endif
                            </td>
                            <td>{{ $library->address }}</td>
                            <td>
                                <small class="text-muted">
                                    {{ $library->latitude }}, {{ $library->longitude }}
                                </small>
                            </td>
                            <td>{{ $library->phone ?? '-' }}</td>
                            <td>
                                @if($library->is_active)
                                <span class="badge rounded-pill" style="background:var(--success);color:white;">Aktif</span>
                                @else
                                <span class="badge rounded-pill" style="background:var(--danger);color:white;">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('libraries.edit', $library) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('libraries.destroy', $library) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus perpustakaan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada perpustakaan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
