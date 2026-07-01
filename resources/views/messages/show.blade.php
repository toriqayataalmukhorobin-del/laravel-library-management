@extends('layout')

@section('page-title', 'Detail Pesan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-4 text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-envelope-open" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">Detail Pesan</h3>
                                <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">Dari: {{ $message->user->name }}</p>
                            </div>
                        </div>
                        <a href="{{ route('messages.admin') }}" class="btn btn-light rounded-4 fw-semibold" style="padding: 0.625rem 1.5rem;">
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
                    <div class="mb-5">
                        <h5 class="fw-bold mb-3" style="color: var(--text-primary);">Balasan Admin</h5>
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
                    </div>
                    @endif

                    @if($message->status !== 'replied')
                    <div class="p-4 rounded-4" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                        <h5 class="fw-bold mb-3" style="color: var(--text-primary);">Balas Pesan</h5>
                        <form action="{{ route('messages.reply', $message->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <textarea name="reply" class="form-control rounded-4" rows="4" required placeholder="Tulis balasan Anda..." style="padding: 0.875rem 1.25rem; resize: vertical;"></textarea>
                            </div>
                            <button type="submit" class="btn btn-lg rounded-4 fw-semibold" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none; padding: 0.875rem 2rem; box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);">
                                <i class="bi bi-send me-2"></i>Kirim Balasan
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
