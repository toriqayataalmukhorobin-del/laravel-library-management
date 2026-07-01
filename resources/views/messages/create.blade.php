@extends('layout')

@section('page-title', 'Kirim Pesan ke Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-envelope" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">Kirim Pesan ke Admin</h3>
                            <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">Sampaikan keluhan, pertanyaan, atau saran Anda</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="subject" class="form-label fw-semibold" style="font-size: 0.95rem; color: var(--text-secondary);">
                                <i class="bi bi-chat-quote me-2"></i>Subjek <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="subject" class="form-control form-control-lg rounded-4" id="subject"
                                   value="{{ old('subject') }}" required placeholder="Masukkan subjek pesan"
                                   style="padding: 0.875rem 1.25rem;">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold" style="font-size: 0.95rem; color: var(--text-secondary);">
                                <i class="bi bi-chat-dots me-2"></i>Pesan <span class="text-danger">*</span>
                            </label>
                            <textarea name="message" class="form-control rounded-4" id="message" rows="6"
                                      required placeholder="Tuliskan pesan Anda di sini..."
                                      style="padding: 0.875rem 1.25rem; resize: vertical;">{{ old('message') }}</textarea>
                            <div class="form-text" style="font-size: 0.85rem;">Maksimal 2000 karakter</div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-lg rounded-4 fw-semibold" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.875rem 2rem; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                <i class="bi bi-send me-2"></i>Kirim Pesan
                            </button>
                            <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-lg rounded-4" style="padding: 0.875rem 2rem;">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
