@extends('layout')

@section('page-title', 'Panduan Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header py-4 text-white" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <div class="d-flex align-items-center">
                        <div class="me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-shield-lock" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 fw-bold" style="font-size: 1.5rem;">Panduan Admin</h3>
                            <p class="mb-0" style="opacity: 0.9; font-size: 0.9rem;">Panduan lengkap administrator sistem PerpustakaanKU</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    <div class="guide-content" style="line-height: 1.9; max-width: 900px;">
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.guide-content h1 {
    color: var(--text-primary);
    font-size: 2.25rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 3px solid var(--accent);
    letter-spacing: -0.5px;
}

.guide-content h2 {
    color: var(--text-primary);
    font-size: 1.75rem;
    font-weight: 700;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid var(--border-color);
    letter-spacing: -0.3px;
}

.guide-content h3 {
    color: var(--text-primary);
    font-size: 1.4rem;
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
    letter-spacing: -0.2px;
}

.guide-content ul {
    padding-left: 1.75rem;
    margin-bottom: 1.25rem;
}

.guide-content li {
    margin-bottom: 0.75rem;
    color: var(--text-secondary);
}

.guide-content li::marker {
    color: var(--accent);
    font-weight: bold;
}

.guide-content strong {
    color: var(--text-primary);
    font-weight: 700;
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.1), rgba(245, 87, 108, 0.1));
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
}

.guide-content a {
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
    border-bottom: 2px solid transparent;
    transition: all 0.3s ease;
}

.guide-content a:hover {
    border-bottom-color: var(--accent);
}

.guide-content code {
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.15), rgba(245, 87, 108, 0.15));
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.9rem;
    color: var(--accent);
    font-weight: 600;
    border: 1px solid rgba(240, 147, 251, 0.3);
}

.guide-content pre {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 1.5rem;
    border-radius: 12px;
    overflow-x: auto;
    margin: 1.5rem 0;
    border: 1px solid rgba(240, 147, 251, 0.3);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.guide-content pre code {
    background: none;
    padding: 0;
    color: #e0e0e0;
    border: none;
}

.guide-content hr {
    border: none;
    border-top: 2px solid var(--border-color);
    margin: 3rem 0;
    opacity: 0.5;
}

.guide-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow);
}

.guide-content th,
.guide-content td {
    padding: 1rem;
    border: 1px solid var(--border-color);
    text-align: left;
}

.guide-content th {
    background: linear-gradient(135deg, rgba(240, 147, 251, 0.1), rgba(245, 87, 108, 0.1));
    font-weight: 700;
    color: var(--text-primary);
    border-bottom: 2px solid var(--accent);
}

.guide-content tr:hover {
    background: var(--bg-primary);
}
</style>
@endsection
