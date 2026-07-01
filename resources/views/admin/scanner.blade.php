@extends('layout')
@section('title', 'Scanner Kunjungan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                <i class="bi bi-upc-scan d-block mb-2" style="font-size: 2.5rem; color: #38ef7d;"></i>
                <h4 class="mb-0 fw-bold">Scanner Perpustakaan</h4>
                <p class="text-white-50 mb-0 small">Arahkan QR Code Pengguna ke Kamera</p>
            </div>
            
            <div class="card-body p-4 text-center">
                <!-- Pesan Flash -->
                @if (session('error'))
                    <div class="alert alert-danger rounded-3 text-start mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success rounded-3 text-start mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </div>
                @endif

                <!-- Reader Container -->
                <div class="mx-auto overflow-hidden shadow-sm" style="border-radius: 16px; border: 3px dashed var(--accent); max-width: 400px; position: relative;">
                    <div id="reader" style="width: 100%;"></div>
                </div>
                
                <p class="text-muted small mt-4 mb-0">
                    <i class="bi bi-shield-check text-success me-1"></i> Sistem otomatis mendeteksi dan memverifikasi QR Code.
                </p>

                <!-- Hidden form untuk submit hasil scan -->
                <form id="scanForm" action="{{ route('qr-code.scan') }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="qr_data" id="qr_data_input">
                </form>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-light rounded-pill px-4 shadow-sm text-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Kostumisasi tampilan html5-qrcode */
    #reader {
        background: #f8fafc;
    }
    #reader video {
        object-fit: cover;
        border-radius: 12px;
    }
    #reader button {
        background: var(--accent);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        margin: 10px 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    #reader button:hover {
        background: #4f46e5;
        transform: translateY(-2px);
    }
    #reader__dashboard_section_csr span {
        display: none !important; /* hide default text */
    }
    #reader__dashboard_section_swaplink {
        color: var(--accent);
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
        margin-top: 10px;
    }
</style>
@endpush

<!-- Script Scanner -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let isScanned = false; // Mencegah double submit
        
        function onScanSuccess(decodedText, decodedResult) {
            if (isScanned) return;
            
            isScanned = true;
            // Hentikan scanner saat berhasil
            html5QrcodeScanner.clear();
            
            // Putar suara beep (opsional)
            let audio = new Audio('https://www.soundjay.com/buttons/sounds/beep-07a.mp3');
            audio.play().catch(e => console.log("Audio play prevented"));
            
            // Masukkan data ke form dan submit
            document.getElementById('qr_data_input').value = decodedText;
            
            // Tampilkan loading di UI
            document.getElementById('reader').innerHTML = `
                <div class="py-5 text-center text-success">
                    <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                    <h5 class="fw-bold">Memverifikasi Data...</h5>
                </div>
            `;
            
            document.getElementById('scanForm').submit();
        }

        function onScanFailure(error) {
            // Biasanya akan banyak error saat kamera mencari QR, jadi diamkan saja
            // console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { 
                fps: 10, 
                qrbox: {width: 250, height: 250},
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
            },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
@endsection
