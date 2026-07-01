@extends('layout')
@section('page-title', 'Daftar Buku')

@section('content')
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-3">
    <div>
        <h4 class="fw-bold mb-1">Daftar Buku <i class="bi bi-book-fill ms-2" style="color:var(--accent);"></i></h4>
        <p class="mb-0" style="color:var(--text-muted);font-size:0.85rem;">{{ $books->count() }} buku tersedia</p>
    </div>
    @if(Auth::user()->isAdmin())
    <a href="{{ route('books.create') }}" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus-lg me-1"></i>Tambah Buku
    </a>
    @endif
</div>

{{-- Search Bar --}}
<div class="card mb-4">
    <div class="card-body py-3 px-4">
        <div class="row g-3">
            <div class="col-md-8 col-12">
                <div class="position-relative">
                    <i class="bi bi-search position-absolute" style="top:50%;left:14px;transform:translateY(-50%);color:var(--text-muted);"></i>
                    <input type="text" id="liveSearchInput" class="form-control ps-5" placeholder="Cari judul, penulis, atau kategori...">
                </div>
            </div>
            <div class="col-md-4 col-12">
                <select id="categoryFilter" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach (\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

{{-- Book Grid for users, Table for admin --}}
@if(Auth::user()->isAdmin())
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="5%">No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="booksTableBody">
                    @forelse ($books as $index => $book)
                    <tr class="book-row" data-category-id="{{ $book->category_id ?? '' }}">
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-semibold book-title" style="color:var(--text-primary);">{{ $book->title }}</div>
                            <div class="book-author" style="font-size:0.78rem;color:var(--text-muted);">{{ $book->publisher }} · {{ $book->year }}</div>
                        </td>
                        <td>{{ $book->author }}</td>
                        <td>
                            @if($book->category)
                            <span class="badge rounded-pill" style="background:{{ $book->category->color }}22;color:{{ $book->category->color }};font-size:0.75rem;">{{ $book->category->name }}</span>
                            @else
                            <span style="color:var(--text-muted);font-size:0.82rem;">—</span>
                            @endif
                        </td>
                        <td>
                            @php $avail = $book->availableStock(); @endphp
                            <span class="fw-semibold {{ $avail > 0 ? '' : 'text-danger' }}">{{ $avail }}/{{ $book->stock }}</span>
                            @if($avail == 0)
                                <div style="font-size:0.72rem;color:#fc8181;">Habis</div>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#qrModal{{ $book->id }}" title="QR Code">
                                    <i class="bi bi-qr-code"></i>
                                </button>
                                <a class="btn btn-sm btn-info text-white" href="{{ route('books.edit', $book->id) }}">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="m-0">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus buku ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4" style="color:var(--text-muted);">Belum ada data buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
{{-- User: Card Grid View --}}
<div class="row g-3" id="booksTableBody">
    @forelse ($books as $book)
    @php $avail = $book->availableStock(); @endphp
    <div class="col-sm-6 col-lg-4 book-row" data-category-id="{{ $book->category_id ?? '' }}">
        <div class="card h-100 {{ $avail == 0 ? '' : '' }}" style="transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='var(--shadow-lg)'" onmouseout="this.style.transform='';this.style.boxShadow=''">
            <div class="card-body p-4">
                {{-- Status badge --}}
                <div class="d-flex justify-content-between align-items-start mb-3">
                    @if($book->category)
                    <span class="badge rounded-pill" style="background:{{ $book->category->color }}22;color:{{ $book->category->color }};font-size:0.72rem;">{{ $book->category->name }}</span>
                    @else
                    <span></span>
                    @endif
                    @if($avail > 0)
                        <span class="badge rounded-pill" style="background:rgba(72,187,120,0.15);color:#48bb78;font-size:0.72rem;">✓ Tersedia ({{ $avail }})</span>
                    @else
                        <span class="badge rounded-pill" style="background:rgba(252,129,129,0.15);color:#fc8181;font-size:0.72rem;">✗ Habis</span>
                    @endif
                </div>

                <h6 class="fw-bold book-title mb-1" style="color:var(--text-primary);line-height:1.4;">{{ $book->title }}</h6>
                <p class="book-author mb-3" style="font-size:0.8rem;color:var(--text-muted);">{{ $book->author }} · {{ $book->year }}</p>

                <p style="font-size:0.82rem;color:var(--text-secondary);line-height:1.5;" class="mb-3">
                    {{ Str::limit($book->description, 90, '...') ?: 'Tidak ada deskripsi.' }}
                </p>

                <div class="d-flex gap-2 mt-auto">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#qrModal{{ $book->id }}" title="QR Code">
                        <i class="bi bi-qr-code"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1" data-bs-toggle="modal" data-bs-target="#bookModal{{ $book->id }}">Detail</button>
                    @if($avail > 0)
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal{{ $book->id }}">Pinjam</button>
                    @else
                        <button class="btn btn-sm btn-outline-danger" disabled>Habis</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5" style="color:var(--text-muted);">Belum ada data buku.</div>
    @endforelse
</div>
@endif

{{-- Modals --}}
@foreach ($books as $book)
<div class="modal fade" id="bookModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:16px;">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">{{ $book->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row g-2 mb-3">
                    <div class="col-6"><small style="color:var(--text-muted);">Penulis</small><div class="fw-semibold">{{ $book->author ?: '—' }}</div></div>
                    <div class="col-6"><small style="color:var(--text-muted);">Penerbit</small><div class="fw-semibold">{{ $book->publisher ?: '—' }} ({{ $book->year }})</div></div>
                    <div class="col-6"><small style="color:var(--text-muted);">Kategori</small><div class="fw-semibold">{{ $book->category ? $book->category->name : '—' }}</div></div>
                    <div class="col-6"><small style="color:var(--text-muted);">Stok Tersedia</small><div class="fw-semibold {{ $book->availableStock() > 0 ? 'text-success' : 'text-danger' }}">{{ $book->availableStock() }}/{{ $book->stock }}</div></div>
                </div>
                <hr style="border-color:var(--border-color);">
                <p style="font-size:0.9rem;color:var(--text-secondary);">{{ $book->description ?: 'Tidak ada deskripsi tersedia.' }}</p>
            </div>
            @if(!Auth::user()->isAdmin())
            <div class="modal-footer border-0 pt-0 flex-column align-items-stretch">
                @if($book->availableStock() > 0)
                <form action="{{ route('borrowings.store', $book->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.85rem;font-weight:600;">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control form-control-sm rounded-pill px-3" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Pinjam Buku Ini</button>
                    </div>
                </form>
                @else
                <button type="button" class="btn btn-light rounded-pill" data-bs-dismiss="modal">Tutup</button>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Borrow Modal specifically for the direct Pinjam button --}}
<div class="modal fade" id="borrowModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Konfirmasi Pinjam</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3 pb-4">
                <form action="{{ route('borrowings.store', $book->id) }}" method="POST">
                    @csrf
                    <p style="font-size:0.85rem;" class="mb-3">Anda akan meminjam buku <strong>{{ $book->title }}</strong>.</p>
                    <div class="mb-3">
                        <label class="form-label" style="font-size:0.85rem;font-weight:600;">Nomor Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control rounded-pill px-3" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">Pinjam Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="qrModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius:16px;">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center pt-0 pb-4">
                <h6 class="fw-bold mb-1">{{ $book->title }}</h6>
                <p style="font-size:0.75rem;color:var(--text-muted);" class="mb-3">ID Buku: #{{ $book->id }}</p>
                <div class="p-3 rounded-3 d-inline-block mb-3" style="background:white;">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ urlencode('PerpustakaanKU|ID:'.$book->id.'|'.$book->title) }}" alt="QR Code" style="width:160px;height:160px;">
                </div>
                <p class="text-muted small mb-0">Klik kanan → <strong>Save Image</strong></p>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearchInput');
    const categoryFilter = document.getElementById('categoryFilter');
    const rows = document.querySelectorAll('.book-row');
    
    function filterBooks() {
        const q = (searchInput?.value || '').toLowerCase();
        const catId = categoryFilter?.value || '';
        
        rows.forEach(row => {
            const title  = (row.querySelector('.book-title')?.textContent || '').toLowerCase();
            const author = (row.querySelector('.book-author')?.textContent || '').toLowerCase();
            const categoryId = row.dataset.categoryId || '';
            
            const matchesSearch = title.includes(q) || author.includes(q);
            const matchesCategory = !catId || categoryId === catId;
            
            row.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
        });
    }
    
    if (searchInput) {
        searchInput.addEventListener('keyup', filterBooks);
    }
    
    if (categoryFilter) {
        categoryFilter.addEventListener('change', filterBooks);
    }
});
</script>
@endsection
