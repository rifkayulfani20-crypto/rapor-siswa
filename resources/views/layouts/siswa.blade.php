<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Raport Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f0f2f5; display: flex; min-height: 100vh; }

        /* Sidebar */
        .sidebar { width: 220px; background: #2c3e50; color: #ecf0f1; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-header { padding: 15px; background: #1a252f; display: flex; align-items: center; gap: 10px; }
        .sidebar-header .logo { width: 36px; height: 36px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; }
        .sidebar-header span { font-weight: bold; font-size: 14px; color: #ecf0f1; }
        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
        .menu-label { font-size: 10px; text-transform: uppercase; color: #7f8c8d; padding: 12px 15px 4px; letter-spacing: 1px; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #bdc3c7; text-decoration: none; font-size: 13px; transition: background 0.2s; }
        .menu-item:hover, .menu-item.active { background: #3498db; color: #fff; }
        .menu-item i { width: 16px; text-align: center; }

        /* Topbar */
        .main { margin-left: 220px; flex: 1; display: flex; flex-direction: column; }
        .topbar { background: #fff; padding: 0 20px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 15px; font-weight: 600; color: #2c3e50; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; }
        .avatar { width: 32px; height: 32px; background: #3498db; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; }
        .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 12px; cursor: pointer; text-decoration: none; }
        .btn-logout:hover { background: #c0392b; }

        /* Content */
        .content { padding: 25px; flex: 1; }
        .page-title { font-size: 22px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; justify-content: space-between; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-info    { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }

        /* Cards */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); margin-bottom: 20px; }
        .card-header { padding: 15px 20px; border-bottom: 1px solid #eee; font-weight: 600; color: #2c3e50; font-size: 14px; }
        .card-body { padding: 20px; }

        /* Table */
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #2c3e50; color: white; }
        thead th { padding: 10px 12px; text-align: left; font-weight: 600; }
        tbody tr { border-bottom: 1px solid #eee; }
        tbody tr:hover { background: #f8f9fa; }
        tbody td { padding: 9px 12px; vertical-align: middle; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #27ae60; color: white; }
        .badge-primary { background: #3498db; color: white; }
        .badge-warning { background: #f39c12; color: white; }
        .badge-danger  { background: #e74c3c; color: white; }

        footer { background: #fff; padding: 12px 20px; text-align: center; font-size: 12px; color: #7f8c8d; border-top: 1px solid #eee; }
        footer a { color: #27ae60; text-decoration: none; }
    </style>
</head>
<body>

<!-- SIDEBAR SISWA -->
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo"><i class="fas fa-graduation-cap" style="font-size:16px"></i></div>
        <span>SISWA</span>
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('siswa.dashboard') }}" class="menu-item {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt"></i> Dashboard
        </a>

        <div class="menu-label">Raport</div>
        <a href="{{ route('siswa.nilai') }}" class="menu-item {{ request()->routeIs('siswa.nilai') ? 'active' : '' }}">
            <i class="fa fa-file-alt"></i> Nilai Akhir
        </a>
        <a href="{{ route('siswa.raport') }}" class="menu-item {{ request()->routeIs('siswa.raport') ? 'active' : '' }}">
            <i class="fa fa-print"></i> Cetak Raport
        </a>

        <div class="menu-label">Saya</div>
        <a href="{{ route('siswa.profil') }}" class="menu-item {{ request()->routeIs('siswa.profil') ? 'active' : '' }}">
            <i class="fa fa-user"></i> Profil
        </a>
    </nav>
</aside>

<!-- MAIN -->
<div class="main">
    <header class="topbar">
        <span class="topbar-title">e-Raport MTs Rekayasa</span>
        <div class="topbar-right">
            <span class="user-name">{{ auth()->user()->name }}</span>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout"><i class="fa fa-sign-out-alt"></i></button>
            </form>
        </div>
    </header>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success">
                <span><i class="fa fa-check-circle"></i> {{ session('success') }}</span>
            </div>
        @endif
        @yield('content')
    </div>

    <footer>Copyright &copy; 2023 <a href="#">MTs Rekayasa</a>.</footer>
</div>

</body>
</html>
