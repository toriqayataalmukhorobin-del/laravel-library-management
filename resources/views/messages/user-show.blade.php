@extends('layout')

@section('page-title', 'Detail Pesan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-envelope-open" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">Detail Pesan</h3>
                                <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">Pesan Anda ke admin</p>
                            </div>
                        </div>
                        <a href="{{ route('messages.index') }}" class="btn btn-light rounded-4 fw-semibold" style="padding: 0.625rem 1.5rem;">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="mb-5">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h4 class="fw-bold mb-0" style="color: var(--text-primary); font-size: 1.25rem;">{{ $message->subject }}</h4>
                            <span class="badge @if($message->status === 'unread') bg-warning text-dark @elseif($message->status === 'read') bg-info text-white @else bg-success text-white @endif rounded-3">
                                @if($message->status === 'unread') Belum Dibaca @elseif($message->status === 'read') Dibaca @else Dibalas @endif
                            </span>
                        </div>
                        <div class="p-4 rounded-4" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                    {{ strtoupper(substr($message->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="color: var(--text-primary);">{{ $message->user->name }}</div>
                                    <div class="text-muted" style="font-size: 0.85rem;">{{ $message->created_at->format('d M Y H:i') }}</div>
                                </div>
                            </div>
                            <p class="mb-0" style="color: var(--text-secondary); line-height: 1.8;">{{ $message->message }}</p>
                        </div>
                    </div>

                    @if($message->admin_reply)
                    <div class="p-4 rounded-4" style="background: linear-gradient(135deg, rgba(240, 147, 251, 0.1), rgba(245, 87, 108, 0.1)); border: 1px solid rgba(240, 147, 251, 0.3);">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                A
                            </div>
                            <div>
                                <div class="fw-semibold" style="color: var(--text-primary);">Admin</div>
                                <div class="text-muted" style="font-size: 0.85rem;">{{ $message->replied_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                        <p class="mb-0" style="color: var(--text-secondary); line-height: 1.8;">{{ $message->admin_reply }}</p>
                    </div>
                    @else
                    <div class="alert alert-info rounded-3 border-0 shadow-sm" style="background: rgba(102, 126, 234, 0.1);">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Belum ada balasan dari admin.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
