@extends('layout')

@section('content')
<div class="d-flex justify-content-between align-items-center page-header">
    <div>
        <h2 class="mb-1 fw-bold"><i class="bi bi-megaphone-fill me-2 text-primary"></i>Kirim Notifikasi</h2>
        <p class="text-muted mb-0">Kirim pemberitahuan ke pengguna sistem perpustakaan</p>
    </div>
    <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary rounded-pill">
        <i class="bi bi-arrow-left me-1"></i> Riwayat Notifikasi
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('notifications.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kirim Kepada</label>
                        <div class="d-flex gap-3">
                            <div class="form-check form-check-inline border rounded-3 p-3 flex-fill text-center" id="radioAllCard" style="cursor:pointer;">
                                <input class="form-check-input d-none" type="radio" name="recipient" id="radioAll" value="all" checked>
                                <label class="form-check-label w-100" for="radioAll" style="cursor:pointer;">
                                    <i class="bi bi-people-fill fs-2 d-block text-primary mb-1"></i>
                                    <strong>Semua User</strong>
                                    <p class="text-muted small mb-0">Broadcast ke seluruh pengguna</p>
                                </label>
                            </div>
                            <div class="form-check form-check-inline border rounded-3 p-3 flex-fill text-center" id="radioSpecificCard" style="cursor:pointer;">
                                <input class="form-check-input d-none" type="radio" name="recipient" id="radioSpecific" value="specific">
                                <label class="form-check-label w-100" for="radioSpecific" style="cursor:pointer;">
                                    <i class="bi bi-person-fill fs-2 d-block text-success mb-1"></i>
                                    <strong>User Tertentu</strong>
                                    <p class="text-muted small mb-0">Pilih satu pengguna</p>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4" id="userSelectWrapper" style="display:none;">
                        <label for="user_id" class="form-label fw-semibold">Pilih Pengguna</label>
                        <select name="user_id" id="user_id" class="form-select rounded-3">
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} (@{{ $user->username }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Judul Notifikasi</label>
                        <input type="text" name="title" id="title" class="form-control rounded-3"
                               value="{{ old('title') }}" placeholder="Contoh: Buku Anda Hampir Jatuh Tempo" required>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">Isi Pesan</label>
                        <textarea name="message" id="message" class="form-control rounded-3" rows="5"
                                  placeholder="Tulis isi notifikasi di sini..." required>{{ old('message') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg rounded-3">
                            <i class="bi bi-send-fill me-2"></i>Kirim Notifikasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioAll = document.getElementById('radioAll');
    const radioSpecific = document.getElementById('radioSpecific');
    const allCard = document.getElementById('radioAllCard');
    const specificCard = document.getElementById('radioSpecificCard');
    const userSelectWrapper = document.getElementById('userSelectWrapper');

    function updateUI() {
        if (radioSpecific.checked) {
            userSelectWrapper.style.display = 'block';
            specificCard.classList.add('border-success', 'bg-success', 'bg-opacity-10');
            allCard.classList.remove('border-primary', 'bg-primary', 'bg-opacity-10');
        } else {
            userSelectWrapper.style.display = 'none';
            allCard.classList.add('border-primary', 'bg-primary', 'bg-opacity-10');
            specificCard.classList.remove('border-success', 'bg-success', 'bg-opacity-10');
        }
    }

    radioAll.addEventListener('change', updateUI);
    radioSpecific.addEventListener('change', updateUI);
    allCard.addEventListener('click', function() { radioAll.checked = true; updateUI(); });
    specificCard.addEventListener('click', function() { radioSpecific.checked = true; updateUI(); });

    updateUI();
});
</script>
@endsection
