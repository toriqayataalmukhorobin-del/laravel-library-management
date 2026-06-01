@extends('layout')
@section('page-title', 'Tambah Perpustakaan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-plus-circle me-2" style="color:var(--accent);"></i>Tambah Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('libraries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Perpustakaan *</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Alamat *</label>
                            <textarea name="address" class="form-control" rows="3" required>{{ old('address') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Latitude *</label>
                                <input type="number" step="any" name="latitude" class="form-control" required value="{{ old('latitude') }}" placeholder="-6.2088">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Longitude *</label>
                                <input type="number" step="any" name="longitude" class="form-control" required value="{{ old('longitude') }}" placeholder="106.8456">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Telepon</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jam Operasional</label>
                            <input type="text" name="opening_hours" class="form-control" value="{{ old('opening_hours') }}" placeholder="Senin-Jumat: 08:00-17:00">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">URL Gambar</label>
                            <input type="url" name="image" class="form-control" value="{{ old('image') }}">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                            <a href="{{ route('libraries.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
