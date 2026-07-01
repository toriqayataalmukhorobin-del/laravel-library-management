@extends('layout')

@section('page-title', 'Tambah Peminjaman Offline')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center" style="border-radius: 16px 16px 0 0;">
                <div>
                    <h4 class="mb-1 fw-bold"><i class="bi bi-person-badge-fill text-primary me-2"></i>Peminjaman Offline</h4>
                    <p class="text-muted mb-0 small">Catat peminjaman buku untuk pengunjung perpustakaan langsung</p>
                </div>
                <a href="{{ route('borrowings.index') }}" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="bi bi-arrow-left me-1"></i>Kembali
                </a>
            </div>
            <div class="card-body p-4">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('borrowings.store-offline') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="card border border-light bg-light bg-opacity-50" style="border-radius: 12px;">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-4 fs-6 text-primary">Informasi Peminjam</h5>
                                    
                                    <div class="mb-4">
                                        <label for="borrower_name" class="form-label fw-semibold">Nama Peminjam <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0 bg-white"><i class="bi bi-person text-muted"></i></span>
                                            <input type="text" name="borrower_name" class="form-control border-start-0 ps-0" id="borrower_name"
                                                value="{{ old('borrower_name') }}" required placeholder="Masukkan nama lengkap peminjam">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="phone" class="form-label fw-semibold">Nomor Telepon <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0 bg-white"><i class="bi bi-telephone text-muted"></i></span>
                                            <input type="text" name="phone" class="form-control border-start-0 ps-0" id="phone"
                                                value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="book_id" class="form-label fw-semibold">Buku yang Dipinjam <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text border-end-0 bg-white"><i class="bi bi-book text-muted"></i></span>
                                            <select name="book_id" class="form-select border-start-0 ps-0" id="book_id" required>
                                                <option value="">-- Pilih Buku --</option>
                                                @foreach ($books as $book)
                                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                                        {{ $book->title }} ({{ $book->author }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-5">
                            <div class="card border border-light bg-light bg-opacity-50 h-100" style="border-radius: 12px;">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-bold mb-4 fs-6 text-primary">Durasi & Catatan</h5>
                                    
                                    <div class="mb-4">
                                        <label for="borrow_date" class="form-label fw-semibold">Tanggal Pinjam <span class="text-danger">*</span></label>
                                        <input type="date" name="borrow_date" class="form-control bg-white" id="borrow_date"
                                            value="{{ old('borrow_date', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="return_date" class="form-label fw-semibold">Batas Kembali <span class="text-danger">*</span></label>
                                        <input type="date" name="return_date" class="form-control bg-white" id="return_date"
                                            value="{{ old('return_date', \Carbon\Carbon::today()->addDays(7)->format('Y-m-d')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label fw-semibold">Catatan (Opsional)</label>
                                        <textarea name="notes" class="form-control bg-white" id="notes" rows="2"
                                                placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                        <a href="{{ route('borrowings.index') }}" class="btn btn-light rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-save me-2"></i>Simpan Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Set minimum date for return date to be after borrow date
document.addEventListener('DOMContentLoaded', function() {
    const borrowDate = document.getElementById('borrow_date');
    const returnDate = document.getElementById('return_date');
    
    borrowDate.addEventListener('change', function() {
        returnDate.min = this.value;
        if (returnDate.value && returnDate.value <= this.value) {
            returnDate.value = '';
        }
    });
    
    // Set initial min date
    returnDate.min = borrowDate.value;
});
</script>
@endsection
