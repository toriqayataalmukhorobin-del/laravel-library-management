@extends('layout')
@section('page-title', 'Tambah Buku Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1"><i class="bi bi-book-fill me-2 text-primary"></i>Tambah Buku Baru</h4>
                        <p class="text-muted small mb-0">Isi data buku dengan lengkap</p>
                    </div>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('books.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" placeholder="Masukkan judul buku" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="author" class="form-label fw-semibold">Penulis</label>
                            <input type="text" name="author" class="form-control" id="author" value="{{ old('author') }}" placeholder="Nama penulis">
                        </div>
                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-semibold">Penerbit</label>
                            <input type="text" name="publisher" class="form-control" id="publisher" value="{{ old('publisher') }}" placeholder="Nama penerbit">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold">Tahun Terbit</label>
                            <input type="number" name="year" class="form-control" id="year" value="{{ old('year') }}" placeholder="2024">
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-semibold">Kategori</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach (\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="stock" class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" id="stock" value="{{ old('stock', 1) }}" min="1" required>
                            <div class="form-text">Berapa eksemplar buku ini tersedia.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi / Sinopsis</label>
                        <textarea class="form-control" name="description" id="description" rows="4" placeholder="Masukkan deskripsi buku">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('books.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-save me-2"></i>Simpan Buku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
