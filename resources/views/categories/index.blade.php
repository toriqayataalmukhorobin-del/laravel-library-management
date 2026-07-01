@extends('layout')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kategori Buku <i class="bi bi-tags-fill ms-2" style="color:var(--accent);"></i></h4>
        <p class="mb-0" style="color:var(--text-muted);font-size:0.85rem;">{{ $categories->count() }} kategori tersedia</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </button>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row g-3">
    @forelse($categories as $cat)
    <div class="col-sm-6 col-lg-4">
        <div class="card h-100" style="border-radius:16px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:48px;height:48px;background:{{ $cat->color }}22;font-size:1.3rem;color:{{ $cat->color }};">
                        <i class="bi {{ $cat->icon ?: 'bi-folder' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold" style="color:var(--text-primary);font-size:1rem;">{{ $cat->name }}</div>
                        <div style="font-size:0.78rem;color:var(--text-muted);">{{ $cat->books_count }} buku</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary rounded-3"
                            data-bs-toggle="modal" data-bs-target="#editModal{{ $cat->id }}"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST"
                              onsubmit="return confirm('Hapus kategori {{ $cat->name }}?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="progress" style="height:6px;border-radius:4px;background:var(--border-color);">
                    <div class="progress-bar" style="width:100%;background:{{ $cat->color }};border-radius:4px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal{{ $cat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow" style="border-radius:16px;">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold">Edit Kategori</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-3">
                    <form action="{{ route('categories.update', $cat->id) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.85rem;">Nama Kategori</label>
                            <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.85rem;">Icon Bootstrap (<a href="https://icons.getbootstrap.com" target="_blank">cari ikon</a>)</label>
                            <input type="text" name="icon" class="form-control" value="{{ $cat->icon }}" placeholder="bi-folder">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size:0.85rem;">Warna</label>
                            <div class="d-flex gap-2 align-items-center">
                                <input type="color" name="color" class="form-control form-control-color" value="{{ $cat->color }}" style="width:50px;height:40px;padding:4px;">
                                <small style="color:var(--text-muted);">Pilih warna kartu</small>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card text-center p-5">
            <div style="font-size:3rem;color:var(--text-muted);" class="mb-3"><i class="bi bi-tags"></i></div>
            <h6 style="color:var(--text-secondary);">Belum ada kategori</h6>
            <p style="color:var(--text-muted);font-size:0.85rem;">Tambahkan kategori untuk mengelompokkan buku.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- Add Category Modal --}}
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Tambah Kategori Baru</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Teknologi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Icon Bootstrap (<a href="https://icons.getbootstrap.com" target="_blank">cari ikon</a>)</label>
                        <input type="text" name="icon" class="form-control" placeholder="bi-laptop" value="bi-folder">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.85rem;">Warna</label>
                        <div class="d-flex gap-2 align-items-center">
                            <input type="color" name="color" class="form-control form-control-color" value="#4299e1" style="width:50px;height:40px;padding:4px;">
                            <small style="color:var(--text-muted);">Pilih warna kartu</small>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">Tambah Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
