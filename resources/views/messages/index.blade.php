@extends('layout')

@section('page-title', 'Pesan Saya')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-envelope" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">Pesan Saya</h3>
                                <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">Riwayat pesan ke admin</p>
                            </div>
                        </div>
                        <a href="{{ route('messages.create') }}" class="btn btn-light rounded-4 fw-semibold" style="padding: 0.625rem 1.5rem;">
                            <i class="bi bi-plus-lg me-1"></i>Pesan Baru
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($messages->isEmpty())
                        <div class="text-center py-5">
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                                <i class="bi bi-inbox" style="font-size: 3rem; color: var(--accent);"></i>
                            </div>
                            <h4 class="fw-bold" style="color: var(--text-primary);">Belum ada pesan</h4>
                            <p class="text-muted">Kirim pesan ke admin untuk keluhan atau pertanyaan</p>
                            <a href="{{ route('messages.create') }}" class="btn btn-primary rounded-4 mt-3">
                                <i class="bi bi-plus-lg me-1"></i>Kirim Pesan
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr style="background: var(--bg-primary);">
                                        <th style="padding: 1rem;">Subjek</th>
                                        <th style="padding: 1rem;">Status</th>
                                        <th style="padding: 1rem;">Tanggal</th>
                                        <th style="padding: 1rem;" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $message)
                                    <tr>
                                        <td style="padding: 1rem;">
                                            <div class="fw-semibold" style="color: var(--text-primary);">{{ $message->subject }}</div>
                                            <div class="text-muted" style="font-size: 0.85rem;">{{ Str::limit($message->message, 80) }}</div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            @if($message->status === 'unread')
                                                <span class="badge bg-warning text-dark rounded-3">Belum Dibaca</span>
                                            @elseif($message->status === 'read')
                                                <span class="badge bg-info text-white rounded-3">Dibaca</span>
                                            @elseif($message->status === 'replied')
                                                <span class="badge bg-success text-white rounded-3">Dibalas</span>
                                            @endif
                                        </td>
                                        <td style="padding: 1rem; color: var(--text-secondary); font-size: 0.9rem;">
                                            {{ $message->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td style="padding: 1rem;" class="text-center">
                                            <a href="{{ route('messages.user-show', $message->id) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
