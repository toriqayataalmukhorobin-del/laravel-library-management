@extends('layout')
@section('page-title', 'Peta Perpustakaan')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-map me-2" style="color:var(--accent);"></i>Peta Perpustakaan</h5>
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('libraries.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-gear me-1"></i>Kelola
                    </a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 350px; width: 100%; border-radius: 0 0 var(--card-radius) var(--card-radius);"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-list-ul me-2" style="color:var(--accent);"></i>Daftar Perpustakaan</h5>
                </div>
                <div class="card-body p-0">
                    @if($libraries->count() > 0)
                    <div class="library-list" style="max-height: 350px; overflow-y: auto;">
                        @foreach($libraries as $library)
                        <div class="library-item p-3 border-bottom" style="border-color:var(--border-color); cursor:pointer; transition:all 0.2s ease;" onclick="focusLibrary({{ $library->latitude }}, {{ $library->longitude }})">
                            <div class="d-flex align-items-start gap-3">
                                <div class="library-icon flex-shrink-0" style="width:48px;height:48px;background:var(--accent-gradient);border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-size:1.2rem;">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $library->name }}</h6>
                                    <p class="text-muted small mb-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $library->address }}</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @if($library->opening_hours)
                                        <span class="badge" style="background:var(--bg-primary);color:var(--text-secondary);font-size:0.75rem;">
                                            <i class="bi bi-clock me-1"></i>{{ $library->opening_hours }}
                                        </span>
                                        @endif
                                        @if($library->phone)
                                        <span class="badge" style="background:var(--bg-primary);color:var(--text-secondary);font-size:0.75rem;">
                                            <i class="bi bi-telephone me-1"></i>{{ $library->phone }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-4 text-center text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        Belum ada perpustakaan
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        z-index: 1;
    }
    .leaflet-popup-content-wrapper {
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .leaflet-popup-content {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }
    .library-item:hover {
        background: var(--bg-primary);
    }
    .library-item:last-child {
        border-bottom: none !important;
    }
    .library-list::-webkit-scrollbar {
        width: 6px;
    }
    .library-list::-webkit-scrollbar-track {
        background: var(--bg-primary);
    }
    .library-list::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 3px;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const libraries = @json($libraries);
    let map;
    let markers = {};

    // Initialize map centered on Indonesia
    map = L.map('map').setView([-2.5489, 118.0149], 5);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers for each library
    libraries.forEach(function(library) {
        if (library.latitude && library.longitude) {
            const marker = L.marker([library.latitude, library.longitude]).addTo(map);

            const popupContent = `
                <div style="min-width: 250px; padding: 8px;">
                    <h6 style="margin: 0 0 12px 0; font-weight: 700; font-size: 16px; color: #333;">${library.name}</h6>
                    <p style="margin: 0 0 10px 0; font-size: 13px; color: #666; line-height: 1.5;">${library.address}</p>
                    ${library.phone ? `<p style="margin: 0 0 8px 0; font-size: 13px; color: #444;"><i class="bi bi-telephone-fill" style="color:var(--accent);"></i> ${library.phone}</p>` : ''}
                    ${library.email ? `<p style="margin: 0 0 8px 0; font-size: 13px; color: #444;"><i class="bi bi-envelope-fill" style="color:var(--accent);"></i> ${library.email}</p>` : ''}
                    ${library.opening_hours ? `<p style="margin: 0; font-size: 13px; color: #444;"><i class="bi bi-clock-fill" style="color:var(--accent);"></i> ${library.opening_hours}</p>` : ''}
                </div>
            `;

            marker.bindPopup(popupContent);
            markers[library.id] = marker;
        }
    });

    // Fit map to show all markers
    if (libraries.length > 0) {
        const group = new L.featureGroup(
            libraries
                .filter(lib => lib.latitude && lib.longitude)
                .map(lib => L.marker([lib.latitude, lib.longitude]))
        );
        map.fitBounds(group.getBounds().pad(0.1));
    }

    // Function to focus on specific library
    window.focusLibrary = function(lat, lng) {
        map.setView([lat, lng], 13);
    };
});
</script>
@endpush
