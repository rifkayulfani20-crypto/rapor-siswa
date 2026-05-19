<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Raport MTs Rekayasa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { corePlugins: { preflight: false } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }
        .sidebar { width: 220px; background: #2c3e50; color: #ecf0f1; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-header { padding: 15px; background: #1a252f; display: flex; align-items: center; gap: 10px; }
        .sidebar-header .logo { width: 36px; height: 36px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; }
        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
        .menu-label { font-size: 10px; text-transform: uppercase; color: #7f8c8d; padding: 12px 15px 4px; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #bdc3c7; text-decoration: none; font-size: 13px; cursor: pointer; transition: background 0.2s; border: none; background: none; width: 100%; text-align: left; }
        .menu-item:hover, .menu-item.active { background: #3498db; color: #fff; }
        .menu-item i { width: 16px; text-align: center; }
        .submenu { background: #243342; display: none; }
        .submenu.open { display: block; }
        .submenu .menu-item { padding-left: 35px; font-size: 12px; }
        .menu-arrow { margin-left: auto; font-size: 10px; transition: transform 0.2s; }
        .open > .menu-arrow { transform: rotate(180deg); }
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 0 20px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 15px; font-weight: 600; color: #2c3e50; }
        .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; }
        .avatar { width: 32px; height: 32px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; }
        .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; }
        .btn-logout:hover { background: #c0392b; }
        .content { padding: 25px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .card-header { padding: 15px 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 20px; }
        .btn { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 5px; font-size: 13px; cursor: pointer; border: none; text-decoration: none; }
        .btn-primary { background: #3498db; color: white; }
        .btn-success { background: #27ae60; color: white; }
        .btn-warning { background: #f39c12; color: white; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-info { background: #17a2b8; color: white; }
        .btn-sm { padding: 4px 8px; font-size: 11px; }
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #2c3e50; color: white; }
        thead th { padding: 10px 12px; text-align: left; font-weight: 600; }
        tbody tr { border-bottom: 1px solid #eee; }
        tbody tr:hover { background: #f8f9fa; }
        tbody td { padding: 9px 12px; vertical-align: middle; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #27ae60; color: white; }
        .badge-danger { background: #e74c3c; color: white; }
        .badge-warning { background: #f39c12; color: white; }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }
        .form-control:focus { outline: none; border-color: #3498db; box-shadow: 0 0 0 2px rgba(52,152,219,0.15); }
        .table-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
        .search-box { padding: 7px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; width: 220px; }
        .per-page { padding: 6px 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; text-decoration: none; color: #2c3e50; }
        .pagination .active span { background: #3498db; color: white; border-color: #3498db; }
        footer { background: #fff; padding: 12px 20px; text-align: center; font-size: 12px; color: #7f8c8d; border-top: 1px solid #eee; }
        footer a { color: #27ae60; text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR GURU -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">G</div>
        <span>GURU</span>
    </div>
    <nav class="sidebar-menu">

        <a href="{{ route('guru.dashboard') }}" class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="menu-label">Master Data</div>

        {{-- BIODATA --}}
        <button class="menu-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}"
                onclick="toggleMenu('biodata')">
            <i class="fa fa-id-card"></i> Biodata
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.siswa.*') ? 'open' : '' }}" id="biodata">
            <a href="{{ route('guru.siswa.index') }}" class="menu-item {{ request()->routeIs('guru.siswa.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Siswa
            </a>
        </div>

        {{-- WALI KELAS --}}
        <button class="menu-item {{ request()->routeIs('guru.walikelas.*') ? 'active' : '' }}"
                onclick="toggleMenu('walikelas')">
            <i class="fa fa-chalkboard-teacher"></i> Wali Kelas
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.walikelas.*') ? 'open' : '' }}" id="walikelas">
            <a href="{{ route('guru.walikelas.kelas') }}" class="menu-item {{ request()->routeIs('guru.walikelas.kelas') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Kelas
            </a>
            <a href="{{ route('guru.walikelas.nilaiSosial') }}" class="menu-item {{ request()->routeIs('guru.walikelas.nilaiSosial') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Nilai Sosial
            </a>
            <a href="{{ route('guru.walikelas.nilaiSpiritual') }}" class="menu-item {{ request()->routeIs('guru.walikelas.nilaiSpiritual') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Nilai Spiritual
            </a>
            <a href="{{ route('guru.walikelas.ketidakhadiran') }}" class="menu-item {{ request()->routeIs('guru.walikelas.ketidakhadiran') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Ketidakhadiran
            </a>
            <a href="{{ route('guru.walikelas.catatan') }}" class="menu-item {{ request()->routeIs('guru.walikelas.catatan') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Catatan
            </a>
            <a href="{{ route('guru.walikelas.prestasi') }}" class="menu-item {{ request()->routeIs('guru.walikelas.prestasi') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Prestasi
            </a>
        </div>

        {{-- GURU MAPEL --}}
        <button class="menu-item {{ request()->routeIs('guru.mapel.*') ? 'active' : '' }}"
                onclick="toggleMenu('gurumapel')">
            <i class="fa fa-book"></i> Guru Mapel
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.mapel.*') ? 'open' : '' }}" id="gurumapel">
            <a href="{{ route('guru.mapel.nilai') }}" class="menu-item {{ request()->routeIs('guru.mapel.nilai') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Nilai Pelajaran
            </a>
        </div>

        {{-- PEMBINA EKSKUL --}}
        <button class="menu-item {{ request()->routeIs('guru.ekskul.*') ? 'active' : '' }}"
                onclick="toggleMenu('ekskul')">
            <i class="fa fa-running"></i> Pembina Ekskul
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('guru.ekskul.*') ? 'open' : '' }}" id="ekskul">
            <a href="{{ route('guru.ekskul.nilai') }}" class="menu-item {{ request()->routeIs('guru.ekskul.nilai') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Input Nilai Ekskul
            </a>
        </div>

        <div class="menu-label">Raport</div>
        <a href="{{ route('guru.nilaiakhir') }}" class="menu-item {{ request()->routeIs('guru.nilaiakhir') ? 'active' : '' }}">
            <i class="fa fa-file-alt"></i> Nilai Akhir
        </a>
        <a href="{{ route('guru.raport') }}" class="menu-item {{ request()->routeIs('guru.raport') ? 'active' : '' }}">
            <i class="fa fa-print"></i> Cetak Raport
        </a>

        <div class="menu-label">Saya</div>
        <a href="{{ route('guru.profil') }}" class="menu-item {{ request()->routeIs('guru.profil') ? 'active' : '' }}">
            <i class="fa fa-user"></i> Profil
        </a>

    </nav>
</aside>

<!-- MAIN -->
<div class="main">
    <header class="topbar">
        <span class="topbar-title">e-Raport MTs Rekayasa</span>
        <div class="flex items-center gap-3">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <footer>
        Copyright &copy; 2023 <a href="#">MTs Rekayasa</a>.
    </footer>
</div>

<script>
function toggleMenu(id) {
    const submenu = document.getElementById(id);
    submenu.classList.toggle('open');
}
</script>
@stack('scripts')
</body>
</html>