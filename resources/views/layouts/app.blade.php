<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengolahan Rapor Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            corePlugins: { preflight: false }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #ffffff; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 220px; background: #ffffff; color: #2c3e50; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid #e0e0e0; }
        .sidebar-header { padding: 15px; background: #f5f5f5; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e0e0e0; }
        .sidebar-header .logo { width: 36px; height: 36px; background: #2c3e50; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; color: white; }
        .sidebar-header span { font-weight: bold; font-size: 14px; color: #2c3e50; }
        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; background: #ffffff; }
        .menu-label { font-size: 10px; text-transform: uppercase; color: #aaaaaa; padding: 12px 15px 4px; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #555555; text-decoration: none; font-size: 13px; cursor: pointer; transition: background 0.2s; border: none; background: none; width: 100%; text-align: left; }
        .menu-item:hover, .menu-item.active { background: #2c3e50; color: #ffffff; }
        .menu-item i { width: 16px; text-align: center; }
        .submenu { background: #f9f9f9; display: none; border-left: 3px solid #2c3e50; }
        .submenu.open { display: block; }
        .submenu .menu-item { padding-left: 35px; font-size: 12px; color: #666666; }
        .submenu .menu-item:hover, .submenu .menu-item.active { background: #2c3e50; color: #ffffff; }
        .menu-arrow { margin-left: auto; font-size: 10px; transition: transform 0.2s; }
        .menu-item.open .menu-arrow { transform: rotate(180deg); }

        /* Topbar */
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 0 20px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 15px; }
        .topbar-title { font-size: 15px; font-weight: 600; color: #2c3e50; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; }
        .avatar { width: 32px; height: 32px; background: #2c3e50; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; }
        .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; text-decoration: none; }
        .btn-logout:hover { background: #c0392b; }

        /* Content */
        .content { padding: 25px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }

        /* Alerts */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* Cards */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .card-header { padding: 15px 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 20px; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 5px; padding: 7px 14px; border-radius: 5px; font-size: 13px; cursor: pointer; border: none; text-decoration: none; }
        .btn-primary { background: #2c3e50; color: white; }
        .btn-primary:hover { background: #1a252f; }
        .btn-success { background: #27ae60; color: white; }
        .btn-success:hover { background: #219a52; }
        .btn-warning { background: #f39c12; color: white; }
        .btn-warning:hover { background: #d68910; }
        .btn-danger { background: #e74c3c; color: white; }
        .btn-danger:hover { background: #c0392b; }
        .btn-sm { padding: 4px 8px; font-size: 11px; }
        .btn-info { background: #17a2b8; color: white; }
        .btn-secondary { background: #6c757d; color: white; }

        /* Table */
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

        /* Form */
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
        .form-control { width: 100%; padding: 8px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; transition: border 0.2s; }
        .form-control:focus { outline: none; border-color: #2c3e50; box-shadow: 0 0 0 2px rgba(44,62,80,0.15); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .is-invalid { border-color: #e74c3c !important; }
        .invalid-feedback { color: #e74c3c; font-size: 11px; margin-top: 3px; }

        /* Pagination */
        .pagination { display: flex; gap: 4px; justify-content: center; margin-top: 20px; }
        .pagination a, .pagination span { padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; text-decoration: none; color: #2c3e50; }
        .pagination .active span { background: #2c3e50; color: white; border-color: #2c3e50; }

        /* Search bar */
        .table-toolbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; flex-wrap: wrap; gap: 8px; }
        .search-box { padding: 7px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; width: 220px; }
        .per-page { padding: 6px 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }

        /* Footer */
        footer { background: #fff; padding: 12px 20px; text-align: center; font-size: 12px; color: #7f8c8d; border-top: 1px solid #eee; }
        footer a { color: #27ae60; text-decoration: none; }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">A</div>
        <span>ADMIN</span>
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="menu-label">Master Data</div>

        <button class="menu-item {{ request()->routeIs('siswa.*','walisiswa.*','guru.*','admin.*','akun.*') ? 'active open' : '' }}"
                onclick="toggleMenu('biodata')">
            <i class="fa fa-id-card"></i> Biodata
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('siswa.*','walisiswa.*','guru.*','admin.*','akun.*') ? 'open' : '' }}" id="biodata">
            <a href="{{ route('siswa.index') }}" class="menu-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Siswa
            </a>
            <a href="{{ route('guru.index') }}" class="menu-item {{ request()->routeIs('guru.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Guru
            </a>
            <a href="{{ route('admin.index') }}" class="menu-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Admin
            </a>
            <a href="{{ route('admin.akun.index') }}" class="menu-item {{ request()->routeIs('admin.akun.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Akun
            </a>
        </div>

        <button class="menu-item {{ request()->routeIs('tapel.*','kelas.*','mapel.*') ? 'active open' : '' }}"
                onclick="toggleMenu('admin-menu')">
            <i class="fa fa-cogs"></i> Administrasi
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('tapel.*','kelas.*','mapel.*') ? 'open' : '' }}" id="admin-menu">
            <a href="{{ route('tapel.index') }}" class="menu-item">
                <i class="fa fa-circle fa-xs"></i> Data Tahun Pelajaran
            </a>
            <a href="{{ route('kelas.index') }}" class="menu-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Kelas
            </a>
            <a href="{{ route('mapel.index') }}" class="menu-item {{ request()->routeIs('mapel.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Data Mapel
            </a>
        </div>

        <button class="menu-item {{ request()->routeIs('nilai.*','pembelajaran.*') ? 'active open' : '' }}"
                onclick="toggleMenu('penilaian-menu')">
            <i class="fa fa-star"></i> Penilaian
            <i class="fa fa-chevron-down menu-arrow"></i>
        </button>
        <div class="submenu {{ request()->routeIs('nilai.*','pembelajaran.*') ? 'open' : '' }}" id="penilaian-menu">
            <a href="{{ route('pembelajaran.index') }}" class="menu-item {{ request()->routeIs('pembelajaran.*') ? 'active' : '' }}">
                <i class="fa fa-circle fa-xs"></i> Pembelajaran
            </a>
        </div>

        <div class="menu-label">Raport</div>
        <a href="{{ route('nilai.akhir') }}" class="menu-item {{ request()->routeIs('nilai.akhir') ? 'active' : '' }}">
            <i class="fa fa-file-alt"></i> Nilai Akhir
        </a>
        <a href="{{ route('raport.index') }}" class="menu-item {{ request()->routeIs('raport.*') ? 'active' : '' }}">
            <i class="fa fa-print"></i> Cetak Raport
        </a>

        <div class="menu-label">Saya</div>
        <a href="{{ route('profil.index') }}" class="menu-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
            <i class="fa fa-user"></i> Profil
        </a>
    </nav>
</aside>

<!-- MAIN -->
<div class="main">
    <header class="topbar">
        <div class="topbar-left">
            <span class="topbar-title">Sistem Pengolahan Rapor Siswa</span>
        </div>
        <div class="topbar-right">
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
        Copyright &copy; 2023 <a href="#">sistem pengolahan rapor siswa</a>.
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