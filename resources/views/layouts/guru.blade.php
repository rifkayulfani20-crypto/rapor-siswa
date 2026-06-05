<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'e-Raport') – Sistem Pengolahan Rapor Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { corePlugins: { preflight: false } }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; display: flex; min-height: 100vh; }

        /* ── SIDEBAR ── */
        .sidebar { width: 230px; background: #ffffff; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid #e0e0e0; }
        .sidebar-header { padding: 16px 15px; background: #f5f5f5; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e0e0e0; }
        .sidebar-header .logo { width: 36px; height: 36px; background: #1a3a6c; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 15px; color: white; flex-shrink: 0; }
        .sidebar-header .brand { display: flex; flex-direction: column; }
        .sidebar-header .brand-title { font-weight: 700; font-size: 13px; color: #2c3e50; line-height: 1.2; }
        .sidebar-header .brand-sub { font-size: 10px; color: #999; margin-top: 2px; }

        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
        .sidebar-menu::-webkit-scrollbar { width: 3px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

        .menu-label { font-size: 10px; text-transform: uppercase; color: #aaa; padding: 12px 15px 4px; letter-spacing: 1px; font-weight: 600; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #555; text-decoration: none; font-size: 13px; cursor: pointer; transition: background 0.2s; border: none; background: none; width: 100%; text-align: left; }
        .menu-item:hover { background: #f0f4fb; color: #1a3a6c; }
        .menu-item.active { background: #1a3a6c; color: #ffffff; }
        .menu-item i { width: 17px; text-align: center; font-size: 13px; }
        .menu-arrow { margin-left: auto; font-size: 10px; transition: transform 0.25s; color: #aaa; }
        .menu-btn.is-open .menu-arrow { transform: rotate(180deg); }

        .submenu { background: #fafafa; display: none; border-left: 3px solid #1a3a6c; }
        .submenu.open { display: block; }
        .submenu .menu-item { padding: 8px 15px 8px 36px; font-size: 12px; color: #666; }
        .submenu .menu-item:hover { background: #f0f4fb; color: #1a3a6c; }
        .submenu .menu-item.active { background: #1a3a6c; color: #fff; }
        .submenu .menu-item i { font-size: 6px; width: 14px; }

        .sidebar-footer { padding: 10px 15px; border-top: 1px solid #eee; font-size: 11px; color: #bbb; text-align: center; }

        /* ── TOPBAR ── */
        .main { margin-left: 230px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; padding: 0 22px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 14px; font-weight: 600; color: #2c3e50; display: flex; align-items: center; gap: 8px; }
        .topbar-title i { color: #1a3a6c; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .user-info { display: flex; flex-direction: column; align-items: flex-end; }
        .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; line-height: 1.2; }
        .user-role { font-size: 10px; color: #999; }
        .avatar { width: 32px; height: 32px; background: #1a3a6c; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; flex-shrink: 0; }
        .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 13px; border-radius: 5px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: background 0.2s; }
        .btn-logout:hover { background: #c0392b; }

        /* ── CONTENT ── */
        .content { padding: 24px; flex: 1; }
        .page-title { font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }

        /* ── ALERTS ── */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-info    { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }

        /* ── CARDS ── */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); margin-bottom: 20px; }
        .card-header { padding: 14px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 20px; }

        /* ── BUTTONS ── */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 5px; font-size: 13px; cursor: pointer; border: none; text-decoration: none; font-weight: 500; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.88; }
        .btn-primary   { background: #1a3a6c; color: white; }
        .btn-success   { background: #27ae60; color: white; }
        .btn-warning   { background: #f39c12; color: white; }
        .btn-danger    { background: #e74c3c; color: white; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-info      { background: #17a2b8; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 11px; }

        /* ── TABLE ── */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #1a3a6c; color: white; }
        thead th { padding: 10px 13px; text-align: left; font-weight: 600; font-size: 12px; }
        tbody tr { border-bottom: 1px solid #f0f0f0; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8f9fb; }
        tbody td { padding: 9px 13px; vertical-align: middle; color: #444; }

        .badge { padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #eafaf1; color: #1e8449; }
        .badge-danger  { background: #fdf0f0; color: #c0392b; }
        .badge-warning { background: #fef9e7; color: #d68910; }
        .badge-info    { background: #eaf4fb; color: #1a7db8; }
        .badge-primary { background: #eaf0fb; color: #1a3a6c; }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; transition: border 0.2s; color: #333; }
        .form-control:focus { outline: none; border-color: #1a3a6c; box-shadow: 0 0 0 3px rgba(26,58,108,0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .is-invalid { border-color: #e74c3c !important; }
        .invalid-feedback { color: #e74c3c; font-size: 11px; margin-top: 3px; }

        /* ── PAGINATION ── */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; text-decoration: none; color: #2c3e50; transition: all 0.2s; }
        .pagination a:hover { background: #f0f4fb; border-color: #1a3a6c; }
        .pagination .active span { background: #1a3a6c; color: white; border-color: #1a3a6c; }

        /* ── TOOLBAR ── */
        .table-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; flex-wrap: wrap; gap: 8px; }
        .search-box { padding: 7px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; width: 230px; }
        .search-box:focus { outline: none; border-color: #1a3a6c; }
        .per-page { padding: 7px 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }

        /* ── FOOTER ── */
        footer { background: #fff; padding: 12px 24px; text-align: center; font-size: 12px; color: #aaa; border-top: 1px solid #eee; }
        footer a { color: #1a3a6c; text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR GURU -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">G</div>
        <div class="brand">
            <span class="brand-title">Rapor Siswa</span>
            <span class="brand-sub">Panel Guru</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('guru.dashboard') }}" class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="menu-label">Master Data</div>

        {{-- Wali Kelas --}}
        <button class="menu-item menu-btn {{ request()->routeIs('guru.walikelas.*') ? 'is-open' : '' }}"
                onclick="toggleMenu('walikelas', this)">
            <i class="fas fa-chalkboard-teacher"></i> Wali Kelas
            <i class="fas fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.walikelas.*') ? 'open' : '' }}" id="walikelas">
            <a href="{{ route('guru.walikelas.kelas') }}" class="menu-item {{ request()->routeIs('guru.walikelas.kelas') ? 'active' : '' }}">
                <i class="fas fa-circle fa-xs"></i> Data Kelas
            </a>
            <a href="{{ route('guru.walikelas.nilaiSosial') }}" class="menu-item {{ request()->routeIs('guru.walikelas.nilaiSosial*') ? 'active' : '' }}">
                <i class="fas fa-circle fa-xs"></i> Input Nilai Sosial
            </a>
            <a href="{{ route('guru.walikelas.nilaiSpiritual') }}" class="menu-item {{ request()->routeIs('guru.walikelas.nilaiSpiritual*') ? 'active' : '' }}">
                <i class="fas fa-circle fa-xs"></i> Input Nilai Spiritual
            </a>
            <a href="{{ route('guru.walikelas.ketidakhadiran') }}" class="menu-item {{ request()->routeIs('guru.walikelas.ketidakhadiran*') ? 'active' : '' }}">
                <i class="fas fa-circle fa-xs"></i> Input Ketidakhadiran
            </a>
        </div>

        {{-- Guru Mapel --}}
        <button class="menu-item menu-btn {{ request()->routeIs('guru.mapel.*') ? 'is-open' : '' }}"
                onclick="toggleMenu('mapel', this)">
            <i class="fas fa-book"></i> Guru Mapel
            <i class="fas fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.mapel.*') ? 'open' : '' }}" id="mapel">
            <a href="{{ route('guru.mapel.nilai') }}" class="menu-item {{ request()->routeIs('guru.mapel.*') ? 'active' : '' }}">
                <i class="fas fa-circle fa-xs"></i> Nilai Pelajaran
            </a>
        </div>

        <div class="menu-label">Raport</div>
        <a href="{{ route('guru.nilaiakhir') }}" class="menu-item {{ request()->routeIs('guru.nilaiakhir') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Nilai Akhir
        </a>
        <a href="{{ route('guru.raport') }}" class="menu-item {{ request()->routeIs('guru.raport*') ? 'active' : '' }}">
            <i class="fas fa-print"></i> Cetak Raport
        </a>

        <div class="menu-label">Akun</div>
        <a href="{{ route('guru.profil') }}" class="menu-item {{ request()->routeIs('guru.profil') ? 'active' : '' }}">
            <i class="fas fa-user"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} Rapor Siswa
    </div>
</aside>

<!-- MAIN -->
<div class="main">
    <header class="topbar">
        <div class="topbar-title">
            <i class="fa fa-th-large"></i>
            Sistem Pengolahan Rapor Siswa
        </div>
        <div class="topbar-right">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">Guru</span>
            </div>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info"><i class="fas fa-info-circle"></i> {{ session('info') }}</div>
        @endif

        @yield('content')
    </div>

    <footer>
        Copyright &copy; {{ date('Y') }} <a href="#">Sistem Pengolahan Rapor Siswa</a>
    </footer>
</div>

<script>
function toggleMenu(id, btn) {
    document.querySelectorAll('.submenu').forEach(function(submenu) {
        if (submenu.id !== id) submenu.classList.remove('open');
    });
    document.querySelectorAll('.menu-btn').forEach(function(b) {
        if (b !== btn) b.classList.remove('is-open');
    });
    document.getElementById(id).classList.toggle('open');
    btn.classList.toggle('is-open');
}
</script>
@stack('scripts')
</body>
</html>