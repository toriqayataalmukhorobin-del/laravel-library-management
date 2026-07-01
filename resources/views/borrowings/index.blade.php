@extends('layout')

@section('page-title', Auth::user()->isAdmin() ? 'Semua Riwayat Peminjaman' : 'Riwayat Peminjaman Saya')

@section('content')
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-0 py-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3" style="border-radius: 16px 16px 0 0;">
        <h4 class="mb-0 fw-bold">{{ Auth::user()->isAdmin() ? 'Semua Riwayat Peminjaman' : 'Riwayat Peminjaman Saya' }}</h4>
        @if(Auth::user()->isAdmin())
            <div class="d-flex gap-2">
                <a href="{{ route('borrowings.create-offline') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Offline
                </a>
                <a href="{{ route('borrowings.print', ['filter' => $filter]) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="bi bi-printer-fill me-1"></i>Cetak PDF
                </a>
            </div>
        @endif
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                {{ $errors->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(Auth::user()->isAdmin())
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $filter == 'all' ? 'active' : '' }}" href="{{ route('borrowings.index', ['filter' => 'all']) }}">
                        Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $filter == 'online' ? 'active' : '' }}" href="{{ route('borrowings.index', ['filter' => 'online']) }}">
                        Online
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $filter == 'offline' ? 'active' : '' }}" href="{{ route('borrowings.index', ['filter' => 'offline']) }}">
                        Offline
                    </a>
                </li>
            </ul>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        @if(Auth::user()->isAdmin())
                            <th>Peminjam</th>
                            <th>No. Telp</th>
                        @endif
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        @if(Auth::user()->isAdmin())
                            <th>Tipe</th>
                        @endif
                        <th>Status</th>
                        <th>Denda</th>
                        @if(Auth::user()->isAdmin())
                            <th width="15%" class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($borrowings as $index => $borrowing)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @if(Auth::user()->isAdmin())
                            <td>
                                {{ $borrowing->borrower_display_name }}
                            </td>
                            <td>{{ $borrowing->phone ?: '-' }}</td>
                        @endif
                        <td>{{ $borrowing->book->title ?? 'Buku Dihapus' }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}</td>
                        @if(Auth::user()->isAdmin())
                            <td>
                                @if($borrowing->type == 'online')
                                    <span class="badge bg-info">Online</span>
                                @else
                                    <span class="badge bg-secondary">Offline</span>
                                @endif
                            </td>
                        @endif
                        <td>
                            @if($borrowing->status == 'borrowed')
                                <span class="badge bg-warning text-dark">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if($borrowing->fine > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($borrowing->fine, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        @if(Auth::user()->isAdmin())
                            <td class="text-center">
                                @if($borrowing->status == 'borrowed')
                                    <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-primary">Tandai Kembali</button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ Auth::user()->isAdmin() ? 9 : 6 }}" class="text-center py-4 text-muted">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
