<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PerpustakaanKU — @yield('title', 'Sistem Manajemen Perpustakaan')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-card: #ffffff;
            --bg-sidebar: #1e293b;
            --sidebar-text: rgba(255,255,255,0.7);
            --sidebar-active: #ffffff;
            --sidebar-hover: rgba(255,255,255,0.08);
            --sidebar-active-bg: rgba(99,102,241,0.15);
            --sidebar-accent: #818cf8;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --border-color: #e2e8f0;
            --shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.05), 0 4px 6px rgba(0,0,0,0.1);
            --card-radius: 20px;
            --accent: #6366f1;
            --accent-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --bg-sidebar: #0f172a;
            --sidebar-text: rgba(226,232,240,0.8);
            --sidebar-active: #f1f5f9;
            --sidebar-hover: rgba(99,102,241,0.1);
            --sidebar-active-bg: rgba(99,102,241,0.2);
            --sidebar-accent: #a5b4fc;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --border-color: #334155;
            --shadow: 0 1px 3px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.3), 0 2px 4px rgba(0,0,0,0.2);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.3), 0 4px 6px rgba(0,0,0,0.2);
            --accent: #818cf8;
            --accent-gradient: linear-gradient(135deg, #6366f1, #8b5cf6);
            --success: #34d399;
            --warning: #fbbf24;
            --danger: #f87171;
        }

        /* Dark mode component overrides */
        [data-theme="dark"] .card {
            background: var(--bg-card) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .card-header {
            background: rgba(255,255,255,0.02) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .stat-card {
            background: linear-gradient(145deg, #1e293b, #1e293b) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .table thead th {
            background: #0f172a !important;
            color: var(--text-secondary) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .table td {
            border-color: var(--border-color) !important;
            background: transparent !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .table tbody tr {
            background: transparent !important;
        }
        [data-theme="dark"] .table tbody tr:hover td {
            background: rgba(99,102,241,0.08) !important;
        }
        [data-theme="dark"] .table-light,
        [data-theme="dark"] .table-bordered,
        [data-theme="dark"] .table-hover {
            --bs-table-bg: transparent !important;
            --bs-table-striped-bg: transparent !important;
            --bs-table-hover-bg: rgba(99,102,241,0.08) !important;
            --bs-table-border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select {
            background: #0f172a !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .form-control:focus,
        [data-theme="dark"] .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15) !important;
            background: #1e293b !important;
        }
        [data-theme="dark"] .input-group-text {
            background: #0f172a !important;
            border-color: var(--border-color) !important;
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .modal-content {
            background: #1e293b !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .modal-header {
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .modal-footer {
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        [data-theme="dark"] .btn-light {
            background: #1e293b !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .btn-outline-secondary {
            border-color: var(--border-color) !important;
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .btn-outline-secondary:hover {
            background: #1e293b !important;
            color: var(--text-primary) !important;
        }
        [data-theme="dark"] .btn-outline-primary {
            border-color: var(--accent) !important;
            color: var(--accent) !important;
        }
        [data-theme="dark"] .btn-outline-primary:hover {
            background: rgba(99,102,241,0.15) !important;
        }
        [data-theme="dark"] .badge.bg-light,
        [data-theme="dark"] .badge.bg-secondary {
            background: #1e293b !important;
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .alert-success {
            background: rgba(16,185,129,0.15) !important;
            color: var(--success) !important;
            border-left: 3px solid var(--success) !important;
        }
        [data-theme="dark"] .alert-danger {
            background: rgba(239,68,68,0.15) !important;
            color: var(--danger) !important;
            border-left: 3px solid var(--danger) !important;
        }
        [data-theme="dark"] .alert-warning {
            background: rgba(245,158,11,0.15) !important;
            color: var(--warning) !important;
        }
        [data-theme="dark"] .top-bar {
            background: #1e293b !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .dark-toggle {
            background: #1e293b !important;
            border-color: var(--border-color) !important;
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .dark-toggle:hover {
            color: var(--accent) !important;
        }
        [data-theme="dark"] .dropdown-menu {
            background: #1e293b !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .dropdown-item:hover {
            background: rgba(99,102,241,0.1) !important;
        }
        [data-theme="dark"] hr {
            border-color: var(--border-color) !important;
        }

        * { transition: var(--transition); }
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ====== SIDEBAR ====== */
        .sidebar {
            width: 270px;
            height: 100vh;
            background: var(--bg-sidebar);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            box-shadow: 4px 0 24px rgba(0,0,0,0.12);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-brand {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand h4 {
            color: white;
            font-weight: 800;
            font-size: 1.25rem;
            margin: 0;
            letter-spacing: -0.4px;
        }

        .sidebar-brand p {
            color: var(--sidebar-text);
            font-size: 0.8rem;
            margin: 4px 0 0;
            font-weight: 400;
        }

        .sidebar-brand .brand-icon {
            width: 48px; height: 48px;
            background: var(--accent-gradient);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
            font-size: 1.3rem; color: white;
            box-shadow: 0 8px 20px rgba(99,102,241,0.4);
            transition: all 0.3s ease;
        }

        .sidebar-brand .brand-icon:hover {
            transform: scale(1.05);
        }

        .sidebar-nav { padding: 20px 16px; flex: 1; overflow-y: auto; overflow-x: hidden; }

        .sidebar-nav::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.15);
            border-radius: 3px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.25);
        }

        .nav-section-title {
            color: var(--sidebar-text);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 12px 16px 8px;
            margin-top: 12px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            margin-bottom: 4px;
            gap: 12px;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-active);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: var(--sidebar-active-bg);
            color: var(--sidebar-accent);
            font-weight: 600;
        }

        .sidebar-link i {
            font-size: 1.15rem;
            width: 22px;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .sidebar-link:hover i {
            transform: scale(1.1);
        }

        .sidebar-link .notif-badge {
            margin-left: auto;
            background: #e53e3e;
            color: white;
            border-radius: 10px;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            min-width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .user-profile-sidebar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
        }

        .user-avatar-sidebar {
            width: 36px; height: 36px;
            background: var(--accent-gradient);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; color: white; font-size: 0.85rem;
            flex-shrink: 0;
        }

        .user-info-sidebar { flex: 1; min-width: 0; }
        .user-info-sidebar .name {
            color: white; font-weight: 600; font-size: 0.85rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .user-info-sidebar .role {
            color: var(--sidebar-accent); font-size: 0.7rem; font-weight: 500;
        }

        .sidebar-logout {
            color: var(--sidebar-text);
            background: none; border: none; cursor: pointer;
            padding: 4px 6px; border-radius: 6px;
            font-size: 1.1rem;
            transition: color 0.2s;
        }
        .sidebar-logout:hover { color: #fc8181; }

        /* ====== MAIN CONTENT ====== */
        .main-wrapper {
            margin-left: 270px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.3s ease;
        }

        .top-bar {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            background: rgba(var(--bg-secondary), 0.95);
        }

        .top-bar .page-title-bar {
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--text-primary);
            letter-spacing: -0.3px;
        }

        .top-bar-right { display: flex; align-items: center; gap: 12px; }

        .clock-display {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 8px 16px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .clock-display:hover {
            background: var(--bg-primary);
            border-color: var(--accent);
            box-shadow: var(--shadow);
        }

        .clock-display i {
            color: var(--accent);
            font-size: 1rem;
        }

        .icon-btn {
            width: 42px; height: 42px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            color: var(--text-secondary);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1.05rem;
            text-decoration: none;
            position: relative;
            transition: all 0.25s ease;
        }

        .icon-btn:hover {
            background: var(--bg-primary);
            color: var(--accent);
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .icon-btn .badge-dot {
            position: absolute; top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: #e53e3e; border-radius: 50%;
            border: 2px solid var(--bg-secondary);
        }

        .dark-toggle {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 4px 12px;
            cursor: pointer;
            display: flex; align-items: center; gap: 6px;
            color: var(--text-secondary);
            font-size: 0.8rem;
            font-weight: 500;
        }
        .dark-toggle:hover { color: var(--accent); }

        .content-area {
            padding: 32px;
            flex: 1;
            max-width: 100%;
        }

        /* ====== CARDS ====== */
        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color) !important;
            border-radius: var(--card-radius) !important;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-header {
            background: var(--bg-card) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }

        /* ====== STAT CARDS ====== */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--card-radius);
            padding: 28px;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        /* ====== TABLE ====== */
        .table { color: var(--text-primary); }
        .table thead th {
            background: var(--bg-primary) !important;
            color: var(--text-secondary) !important;
            border-bottom-color: var(--border-color) !important;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td { border-bottom-color: var(--border-color) !important; vertical-align: middle; }
        .table tbody tr:hover { background: var(--bg-primary) !important; }

        /* ====== FORMS ====== */
        .form-control, .form-select {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
            border-radius: 12px !important;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 4px rgba(99,102,241,0.1) !important;
            background: var(--bg-secondary) !important;
        }

        .form-control::placeholder { color: var(--text-muted) !important; }

        .input-group-text {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-secondary) !important;
            border-radius: 12px 0 0 12px !important;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0 !important;
        }

        /* ====== BUTTONS ====== */
        .btn {
            border-radius: 12px !important;
            font-weight: 500;
            padding: 0.625rem 1.25rem;
            font-size: 0.95rem;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:active::after {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--accent-gradient) !important;
            border: none !important;
            box-shadow: 0 4px 14px rgba(99,102,241,0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.5);
        }

        .btn-secondary {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .btn-secondary:hover {
            background: var(--bg-secondary) !important;
            border-color: var(--accent) !important;
            color: var(--accent) !important;
        }

        .btn-outline-primary {
            border-color: var(--accent) !important;
            color: var(--accent) !important;
            background: transparent !important;
        }

        .btn-outline-primary:hover {
            background: rgba(99,102,241,0.1) !important;
            transform: translateY(-1px);
        }

        /* ====== ALERTS ====== */
        .alert {
            border: none !important;
            border-radius: 12px !important;
        }

        /* ====== BADGE ====== */
        .badge { border-radius: 8px !important; font-weight: 500; }

        /* ====== PAGE HEADER ====== */
        .page-header { margin-bottom: 28px; }
        .page-header h2 { font-weight: 800; color: var(--text-primary); }
        .page-header p { color: var(--text-secondary); }

        /* ====== MOBILE TOGGLE ====== */
        .mobile-menu-btn {
            display: none;
            background: none; border: none;
            font-size: 1.3rem;
            color: var(--text-primary);
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .main-wrapper { margin-left: 0; }
            .mobile-menu-btn { display: flex; }
            .content-area { padding: 20px; }
            .top-bar { padding: 12px 20px; }
            .top-bar .page-title-bar { font-size: 1rem; }
        }

        @media (max-width: 576px) {
            .content-area { padding: 16px; }
            .stat-card { padding: 20px; }
            .card { border-radius: 16px !important; }
        }

        /* ====== DROPDOWN MENU ====== */
        .dropdown-menu {
            background: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 12px !important;
            box-shadow: var(--shadow-lg) !important;
        }
        .dropdown-item { color: var(--text-primary) !important; border-radius: 8px; margin: 2px 6px; width: calc(100% - 12px); }
        .dropdown-item:hover { background: var(--bg-primary) !important; }
        .dropdown-header { color: var(--text-muted) !important; }
        .dropdown-divider { border-color: var(--border-color) !important; }

        /* ====== PAGE TRANSITIONS ====== */
        .page-transition-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--bg-primary);
            z-index: 9999;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .page-transition-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .page-transition-overlay.fade-out {
            opacity: 0;
        }

        .content-area {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:active {
            transform: scale(0.95);
        }

        /* Loading spinner for page transitions */
        .page-loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10000;
            display: none;
        }

        .page-loader.active {
            display: block;
        }

        .page-loader .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid var(--border-color);
            border-top-color: var(--accent);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Page Transition Overlay -->
<div class="page-transition-overlay" id="pageTransitionOverlay"></div>

<!-- Page Loader -->
<div class="page-loader" id="pageLoader">
    <div class="spinner"></div>
</div>

@if(auth()->check())
<!-- ====== SIDEBAR ====== -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
        <h4>PerpustakaanKU</h4>
        <p>Sistem Manajemen Perpustakaan</p>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Menu Utama</div>
        <a href="{{ url('/dashboard') }}" class="sidebar-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="{{ route('books.index') }}" class="sidebar-link {{ request()->is('books*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> Daftar Buku
        </a>
        <a href="{{ route('borrowings.index') }}" class="sidebar-link {{ request()->is('borrowings*') ? 'active' : '' }}">
            <i class="bi bi-calendar2-date-fill"></i> Peminjaman
        </a>

        @if(Auth::user()->isAdmin())
        <div class="nav-section-title">Manajemen</div>
        <a href="{{ route('categories.index') }}" class="sidebar-link {{ request()->is('categories*') ? 'active' : '' }}">
            <i class="bi bi-tags-fill"></i> Kategori
        </a>
        <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->is('users*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Data User
        </a>

        <a href="{{ route('notifications.create') }}" class="sidebar-link {{ request()->is('notifications/create') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Kirim Notifikasi
        </a>
        <a href="{{ route('notifications.index') }}" class="sidebar-link {{ request()->is('notifications') ? 'active' : '' }}">
            <i class="bi bi-send-fill"></i> Riwayat Notif
        </a>
        @else
        <div class="nav-section-title">Notifikasi</div>
        @php
            $unreadCount = \App\Models\Notification::where(function($q) {
                $q->where('is_broadcast', true)->orWhere('user_id', Auth::id());
            })->whereDoesntHave('reads', fn($q) => $q->where('user_id', Auth::id()))->count();
        @endphp
        <a href="{{ route('notifications.index') }}" class="sidebar-link {{ request()->is('notifications*') ? 'active' : '' }}">
            <i class="bi bi-bell-fill"></i> Notifikasi
            @if($unreadCount > 0)
                <span class="notif-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            @endif
        </a>
        @endif
        
        <div class="nav-section-title">Bantuan</div>
        <a href="{{ route('guide.user') }}" class="sidebar-link {{ request()->is('guide/user') ? 'active' : '' }}">
            <i class="bi bi-book"></i> Panduan Pengguna
        </a>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('guide.admin') }}" class="sidebar-link {{ request()->is('guide/admin') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Panduan Admin
        </a>
        @if(Route::has('messages.admin'))
            @php
                $unreadMessages = 0;
                if (\Illuminate\Support\Facades\Schema::hasTable('messages')) {
                    $unreadMessages = \App\Models\Message::where('status', 'unread')->count();
                }
            @endphp
            <a href="{{ route('messages.admin') }}" class="sidebar-link {{ request()->is('admin/messages*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-text"></i> Pesan Masuk
                @if($unreadMessages > 0)
                    <span class="notif-badge">{{ $unreadMessages > 9 ? '9+' : $unreadMessages }}</span>
                @endif
            </a>
        @endif
        @else
        @if(Route::has('messages.index'))
            @php
                $unreadMessages = 0;
                if (\Illuminate\Support\Facades\Schema::hasTable('messages')) {
                    $unreadMessages = \App\Models\Message::where('user_id', Auth::id())->where('status', 'replied')->count();
                }
            @endphp
            <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->is('messages*') ? 'active' : '' }}">
                <i class="bi bi-envelope"></i> Pesan Saya
                @if($unreadMessages > 0)
                    <span class="notif-badge">{{ $unreadMessages > 9 ? '9+' : $unreadMessages }}</span>
                @endif
            </a>
        @endif
        @endif
        
        <div class="nav-section-title">Akun</div>
        <a href="{{ route('qr-code.show') }}" class="sidebar-link {{ request()->is('qr-code') ? 'active' : '' }}">
            <i class="bi bi-qr-code-scan"></i> QR Code Saya
        </a>
        <a href="{{ route('libraries.map') }}" class="sidebar-link {{ request()->is('libraries/map') ? 'active' : '' }}">
            <i class="bi bi-map"></i> Peta Perpustakaan
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-profile-sidebar">
            <div class="user-avatar-sidebar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
            <div class="user-info-sidebar">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">{{ ucfirst(Auth::user()->role) }}</div>
            </div>
        </div>
    </div>
</aside>

<!-- ====== MAIN WRAPPER ====== -->
<div class="main-wrapper">
    <div class="top-bar">
        <div class="d-flex align-items-center gap-3">
            <button class="mobile-menu-btn" onclick="openSidebar()"><i class="bi bi-list"></i></button>
            <span class="page-title-bar d-none d-md-block">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="top-bar-right">
            <!-- Clock Display -->
            <div class="clock-display">
                <i class="bi bi-clock-fill"></i>
                <span id="clock">00:00:00</span>
            </div>
            <!-- Dark Mode Toggle -->
            <button class="dark-toggle me-3" id="darkToggle" onclick="toggleDarkMode()">
                <i class="bi bi-moon-fill" id="darkIcon"></i>
                <span id="darkLabel" class="d-none d-sm-inline">Dark</span>
            </button>
            <!-- Topbar Logout -->
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 py-1 shadow-sm d-inline-flex align-items-center gap-2" title="Keluar">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="content-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
</div>
@else
<!-- Guest: Simple centered layout -->
<div class="w-100 min-vh-100 d-flex flex-column" style="background: var(--bg-primary);">
    <nav class="top-bar" style="margin-left:0; position:static; background: var(--bg-secondary);">
        <a href="{{ url('/') }}" style="text-decoration:none; display:flex; align-items:center; gap:10px; color:var(--text-primary);">
            <div style="width:36px;height:36px;background:var(--accent-gradient);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>
            <strong>PerpustakaanKU</strong>
        </a>
        <div class="top-bar-right">
            <button class="dark-toggle" id="darkToggleGuest" onclick="toggleDarkMode()">
                <i class="bi bi-moon-fill" id="darkIconGuest"></i>
                <span id="darkLabelGuest">Dark</span>
            </button>
        </div>
    </nav>
    <div class="flex-grow-1 d-flex align-items-center justify-content-center p-4">
        @yield('content')
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // ====== DARK MODE ======
    function applyTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const isDark = theme === 'dark';
        const icons = document.querySelectorAll('#darkIcon, #darkIconGuest');
        const labels = document.querySelectorAll('#darkLabel, #darkLabelGuest');
        icons.forEach(el => { el.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-fill'; });
        labels.forEach(el => { el.textContent = isDark ? 'Light' : 'Dark'; });
    }

    function toggleDarkMode() {
        const current = document.documentElement.getAttribute('data-theme');
        const next = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem('theme', next);
        applyTheme(next);
    }

    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    // ====== MOBILE SIDEBAR ======
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebarOverlay').classList.add('show');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('show');
    }

    // ====== PAGE TRANSITIONS ======
    document.addEventListener('DOMContentLoaded', function() {
        const overlay = document.getElementById('pageTransitionOverlay');
        const loader = document.getElementById('pageLoader');

        // Add transition effect to all sidebar links and navigation links
        const navLinks = document.querySelectorAll('.sidebar-link, .icon-btn[href]');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                // Skip if it's a hash link, javascript link, or external link
                if (href && href !== '#' && !href.startsWith('javascript:') && !href.startsWith('http')) {
                    e.preventDefault();
                    // Show transition overlay
                    overlay.classList.add('active');
                    loader.classList.add('active');
                    // Navigate after short delay
                    setTimeout(() => {
                        window.location.href = href;
                    }, 300);
                }
            });
        });

        // Handle form submissions with transitions
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                // Only add transition for GET forms (navigation)
                if (this.method.toLowerCase() === 'get') {
                    overlay.classList.add('active');
                    loader.classList.add('active');
                }
            });
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Real-time clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }

        // Update clock immediately and then every second
        updateClock();
        setInterval(updateClock, 1000);

        // Add smooth focus ring animation for forms
        const formInputs = document.querySelectorAll('.form-control, .form-select');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
