@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-bell-fill me-2 text-primary"></i>Notifikasi Saya</h2>
        <p class="text-muted mb-0">Pemberitahuan dari Admin Perpustakaan</p>
    </div>
    @php $unread = $notifications->filter(fn($n) => !$n->isReadBy(Auth::user()))->count(); @endphp
    @if($unread > 0)
    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-primary rounded-pill">
            <i class="bi bi-check2-all me-1"></i> Tandai Semua Dibaca ({{ $unread }})
        </button>
    </form>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success border-0 rounded-3 alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex flex-column gap-3">
    @forelse($notifications as $notif)
        @php $isRead = $notif->isReadBy(Auth::user()); @endphp
        <div class="card border-0 shadow-sm {{ !$isRead ? 'border-start border-4 border-primary' : '' }}"
             style="border-radius: 12px; {{ !$isRead ? 'border-left: 4px solid #0d6efd !important;' : '' }}">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-start">
                        <div class="me-3 mt-1">
                            @if(!$isRead)
                                <span class="bg-primary rounded-circle d-inline-block" style="width:10px;height:10px;"></span>
                            @else
                                <span class="bg-secondary bg-opacity-25 rounded-circle d-inline-block" style="width:10px;height:10px;"></span>
                            @endif
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <h5 class="fw-bold mb-0 {{ !$isRead ? 'text-primary' : 'text-muted' }}">{{ $notif->title }}</h5>
                                @if(!$isRead)
                                    <span class="badge bg-primary rounded-pill" style="font-size: 0.7rem;">Baru</span>
                                @endif
                                @if($notif->is_broadcast)
                                    <span class="badge bg-secondary rounded-pill" style="font-size: 0.7rem;"><i class="bi bi-megaphone-fill me-1"></i>Broadcast</span>
                                @endif
                            </div>
                            <p class="mb-2 text-dark">{{ $notif->message }}</p>
                            <small class="text-muted">
                                <i class="bi bi-person-badge me-1"></i>Dari: <strong>{{ $notif->sender->name ?? 'Admin' }}</strong>
                                &nbsp;&bull;&nbsp;
                                <i class="bi bi-clock me-1"></i>{{ $notif->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                    @if(!$isRead)
                    <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="ms-3 flex-shrink-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="bi bi-check2 me-1"></i>Tandai Dibaca
                        </button>
                    </form>
                    @else
                    <span class="ms-3 text-success small flex-shrink-0"><i class="bi bi-check2-all"></i> Dibaca</span>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-bell-slash display-3 text-muted d-block mb-3"></i>
                <h5 class="text-muted">Belum ada notifikasi untuk Anda.</h5>
            </div>
        </div>
    @endforelse
</div>
@endsection
