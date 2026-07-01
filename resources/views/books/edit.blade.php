@extends('layout')
@section('page-title', 'Edit Buku')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold mb-1"><i class="bi bi-pencil-fill me-2 text-primary"></i>Edit Buku</h4>
                        <p class="text-muted small mb-0">{{ $book->title }}</p>
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

                <form action="{{ route('books.update', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ $book->title }}" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="author" class="form-label fw-semibold">Penulis</label>
                            <input type="text" name="author" class="form-control" id="author" value="{{ $book->author }}">
                        </div>
                        <div class="col-md-6">
                            <label for="publisher" class="form-label fw-semibold">Penerbit</label>
                            <input type="text" name="publisher" class="form-control" id="publisher" value="{{ $book->publisher }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="year" class="form-label fw-semibold">Tahun Terbit</label>
                            <input type="number" name="year" class="form-control" id="year" value="{{ $book->year }}">
                        </div>
                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-semibold">Kategori</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach (\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="stock" class="form-label fw-semibold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock" class="form-control" id="stock" value="{{ $book->stock }}" min="1" required>
                            @php $active = $book->activeBorrowingsCount(); @endphp
                            <div class="form-text">{{ $active }} dari {{ $book->stock }} sedang dipinjam.</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Deskripsi / Sinopsis</label>
                        <textarea class="form-control" name="description" id="description" rows="4">{{ $book->description }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('books.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
