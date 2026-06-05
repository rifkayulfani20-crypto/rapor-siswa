<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = { corePlugins: { preflight: false } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; display: flex; min-height: 100vh; }

        /* SIDEBAR */
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
        .menu-item i.icon { width: 17px; text-align: center; font-size: 13px; }
        .sidebar-footer { padding: 10px 15px; border-top: 1px solid #eee; font-size: 11px; color: #bbb; text-align: center; }

        /* TOPBAR */
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

        /* CONTENT */
        .content { padding: 24px; flex: 1; }
        .page-title { font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }

        /* ALERT */
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* CARD */
        .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); margin-bottom: 20px; }
        .card-header { padding: 14px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
        .card-body { padding: 20px; }

        /* TABLE */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead { background: #1a3a6c; color: white; }
        thead th { padding: 10px 13px; text-align: left; font-weight: 600; font-size: 12px; }
        tbody tr { border-bottom: 1px solid #f0f0f0; transition: background 0.15s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: #f8f9fb; }
        tbody td { padding: 9px 13px; vertical-align: middle; color: #444; }

        /* BADGE */
        .badge { padding: 3px 9px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-success { background: #eafaf1; color: #1e8449; }
        .badge-danger  { background: #fdf0f0; color: #c0392b; }
        .badge-info    { background: #eaf4fb; color: #1a7db8; }

        /* BTN */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 5px; font-size: 13px; cursor: pointer; border: none; text-decoration: none; font-weight: 500; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.88; }
        .btn-danger  { background: #e74c3c; color: white; }
        .btn-warning { background: #e67e22; color: white; }
        .btn-sm { padding: 4px 10px; font-size: 11px; }

        /* STATS */
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card { background: #fff; border-radius: 8px; padding: 18px 20px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); display: flex; align-items: center; gap: 16px; }
        .stat-icon { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: white; flex-shrink: 0; }
        .stat-info .label { font-size: 12px; color: #999; font-weight: 500; }
        .stat-info .value { font-size: 24px; font-weight: 800; color: #2c3e50; line-height: 1.2; }

        footer { background: #fff; padding: 12px 24px; text-align: center; font-size: 12px; color: #aaa; border-top: 1px solid #eee; }
        footer a { color: #1a3a6c; text-decoration: none; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">K</div>
        <div class="brand">
            <span class="brand-title">Rapor Siswa</span>
            <span class="brand-sub">Kepala Sekolah</span>
        </div>
    </div>

    <nav class="sidebar-menu">
        <a href="{{ route('kepsek.dashboard') }}" class="menu-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
            <i class="fa fa-tachometer-alt icon"></i> Dashboard
        </a>

        <div class="menu-label">Kelola Nilai</div>
        <a href="{{ route('kepsek.dashboard') }}" class="menu-item {{ request()->routeIs('kepsek.*') ? 'active' : '' }}">
            <i class="fa fa-lock icon"></i> Kunci Nilai
        </a>

        <div class="menu-label">Akun</div>
        <a href="{{ route('profil.index') }}" class="menu-item {{ request()->routeIs('profil.*') ? 'active' : '' }}">
            <i class="fa fa-user icon"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-footer">
        &copy; {{ date('Y') }} Rapor Siswa
    </div>
</aside>

{{-- MAIN --}}
<div class="main">
    <header class="topbar">
        <div class="topbar-title">
            <i class="fa fa-th-large"></i>
            Sistem Pengolahan Rapor Siswa
        </div>
        <div class="topbar-right">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">Kepala Sekolah</span>
            </div>
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </header>

    <div class="content">

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="page-title">Dashboard Kepala Sekolah</div>

        {{-- STATS --}}
        @php
            $totalTapel   = $tapels->count();
            $terkunci     = $tapels->where('is_locked', true)->count();
            $terbuka      = $tapels->where('is_locked', false)->count();
        @endphp
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#1a3a6c;">
                    <i class="fa fa-calendar"></i>
                </div>
                <div class="stat-info">
                    <div class="label">Total Tahun Pelajaran</div>
                    <div class="value">{{ $totalTapel }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#e74c3c;">
                    <i class="fa fa-lock"></i>
                </div>
                <div class="stat-info">
                    <div class="label">Nilai Terkunci</div>
                    <div class="value">{{ $terkunci }}</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#27ae60;">
                    <i class="fa fa-lock-open"></i>
                </div>
                <div class="stat-info">
                    <div class="label">Nilai Terbuka</div>
                    <div class="value">{{ $terbuka }}</div>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="card">
            <div class="card-header">
                <span style="font-weight:600;font-size:14px;color:#2c3e50;">
                    <i class="fa fa-lock" style="color:#1a3a6c;margin-right:6px;"></i>
                    Kelola Kunci Nilai Per Tahun Pelajaran
                </span>
            </div>
            <div class="card-body">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;width:50px;">No</th>
                                <th>Tahun Pelajaran</th>
                                <th style="text-align:center;">Semester</th>
                                <th style="text-align:center;">Status Aktif</th>
                                <th style="text-align:center;">Status Nilai</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tapels as $i => $tapel)
                            <tr>
                                <td style="text-align:center;">{{ $i + 1 }}</td>
                                <td><strong>{{ $tapel->nama }}</strong></td>
                                <td style="text-align:center;">{{ $tapel->semester }}</td>
                                <td style="text-align:center;">
                                    @if($tapel->aktif)
                                        <span class="badge badge-success">✅ Aktif</span>
                                    @else
                                        <span class="badge badge-danger">❌ Tidak Aktif</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($tapel->is_locked)
                                        <span class="badge badge-danger">🔒 Terkunci</span>
                                    @else
                                        <span class="badge badge-info">🔓 Terbuka</span>
                                    @endif
                                </td>
                                <td style="text-align:center;">
                                    @if($tapel->is_locked)
                                        <form action="{{ route('kepsek.tapel.unlock', $tapel) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Buka kunci nilai {{ $tapel->nama }}?')">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">
                                                <i class="fa fa-lock-open"></i> Buka Kunci
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('kepsek.tapel.lock', $tapel) }}" method="POST" style="display:inline;"
                                            onsubmit="return confirm('Kunci nilai {{ $tapel->nama }}? Guru tidak bisa mengedit nilai setelah dikunci.')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-lock"></i> Kunci Nilai
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" style="text-align:center;padding:24px;color:#aaa;">
                                    <i class="fa fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                    Belum ada data tahun pelajaran
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <footer>
        Copyright &copy; {{ date('Y') }} <a href="#">Sistem Pengolahan Rapor Siswa</a>
    </footer>
</div>

</body>
</html>