<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sistem Pengolahan Rapor Siswa</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <script>
            tailwind.config = { corePlugins: { preflight: false } }
        </script>
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; display: flex; min-height: 100vh; }

            /* ── SIDEBAR ── */
            .sidebar { width: 230px; background: #ffffff; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid #e0e0e0; transition: transform 0.3s ease; }
            .sidebar.collapsed { transform: translateX(-230px); }
            .sidebar-header { padding: 16px 15px; background: #f5f5f5; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e0e0e0; }
            .sidebar-header .logo { width: 36px; height: 36px; background: #1a3a6c; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 15px; color: white; flex-shrink: 0; }
            .sidebar-header .brand { display: flex; flex-direction: column; }
            .sidebar-header .brand-title { font-weight: 700; font-size: 13px; color: #2c3e50; line-height: 1.2; }
            .sidebar-header .brand-sub { font-size: 10px; color: #999; margin-top: 2px; }

            .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
            .sidebar-menu::-webkit-scrollbar { width: 3px; }
            .sidebar-menu::-webkit-scrollbar-thumb { background: #ddd; border-radius: 4px; }

            .menu-label { font-size: 10px; text-transform: uppercase; color: #aaa; padding: 12px 15px 4px; letter-spacing: 1px; font-weight: 600; }
            .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #555; text-decoration: none; font-size: 13px; cursor: pointer; transition: all 0.2s ease; border: none; background: none; width: 100%; text-align: left; }
            .menu-item:hover { background: #f0f4fb; color: #1a3a6c; padding-left: 20px; }
            .menu-item.active { background: #1a3a6c; color: #ffffff; }
            .menu-item i.icon { width: 17px; text-align: center; font-size: 13px; }
            .menu-arrow { margin-left: auto; font-size: 10px; transition: transform 0.25s; color: #aaa; }
            .menu-toggle.open .menu-arrow { transform: rotate(180deg); }

            .submenu { background: #fafafa; display: none; border-left: 3px solid #1a3a6c; }
            .submenu.open { display: block; animation: slideDown 0.25s ease; }
            .submenu .menu-item { padding: 8px 15px 8px 36px; font-size: 12px; color: #666; }
            .submenu .menu-item:hover { background: #f0f4fb; color: #1a3a6c; padding-left: 40px; }
            .submenu .menu-item.active { background: #1a3a6c; color: #fff; }
            .submenu .menu-item i.icon { font-size: 6px; width: 14px; }

            .sidebar-footer { padding: 10px 15px; border-top: 1px solid #eee; font-size: 11px; color: #bbb; text-align: center; }

            /* ── OVERLAY ── */
            .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 99; }
            .sidebar-overlay.show { display: block; }

            /* ── TOPBAR ── */
            .main { margin-left: 230px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; transition: margin-left 0.3s ease; }
            .main.expanded { margin-left: 0; }
            .topbar { background: #fff; padding: 0 22px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 50; }
            .topbar-title { font-size: 14px; font-weight: 600; color: #2c3e50; display: flex; align-items: center; gap: 8px; }
            .topbar-title i { color: #1a3a6c; }
            .topbar-right { display: flex; align-items: center; gap: 12px; }
            .user-info { display: flex; flex-direction: column; align-items: flex-end; }
            .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; line-height: 1.2; }
            .user-role { font-size: 10px; color: #999; }
            .avatar { width: 32px; height: 32px; background: #1a3a6c; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; flex-shrink: 0; }
            .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 13px; border-radius: 5px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: all 0.2s ease; }
            .btn-logout:hover { background: #c0392b; transform: translateY(-1px); }
            .btn-toggle { background: none; border: none; cursor: pointer; color: #1a3a6c; font-size: 18px; padding: 4px 8px; border-radius: 5px; transition: background 0.2s; }
            .btn-toggle:hover { background: #f0f4fb; }

            /* ── CONTENT ── */
            .content { padding: 24px; flex: 1; }
            .page-title { font-size: 20px; font-weight: 700; color: #2c3e50; margin-bottom: 20px; }

            /* ── ALERTS ── */
            .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; animation: fadeInUp 0.3s ease; }
            .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
            .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

            /* ── CARDS ── */
            .card { background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); margin-bottom: 20px; transition: transform 0.3s ease, box-shadow 0.3s ease; animation: fadeInUp 0.4s ease; }
            .card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(26,58,108,0.12); }
            .card-header { padding: 14px 20px; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; justify-content: space-between; }
            .card-body { padding: 20px; }

            /* ── BUTTONS ── */
            .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; border-radius: 5px; font-size: 13px; cursor: pointer; border: none; text-decoration: none; font-weight: 500; transition: all 0.2s ease; }
            .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); opacity: 0.9; }
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
            tbody tr { border-bottom: 1px solid #f0f0f0; transition: all 0.2s ease; }
            tbody tr:last-child { border-bottom: none; }
            tbody tr:hover { background: #f0f4fb; }
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
            .search-box { padding: 7px 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; width: 230px; transition: border 0.2s; }
            .search-box:focus { outline: none; border-color: #1a3a6c; box-shadow: 0 0 0 3px rgba(26,58,108,0.1); }
            .per-page { padding: 7px 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 13px; }

            /* ── FOOTER ── */
            footer { background: #fff; padding: 12px 24px; text-align: center; font-size: 12px; color: #aaa; border-top: 1px solid #eee; }
            footer a { color: #1a3a6c; text-decoration: none; }

            /* ── ANIMASI ── */
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(20px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @keyframes slideDown {
                from { opacity: 0; transform: translateY(-10px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* ── RESPONSIVE ── */
            @media (max-width: 768px) {
                .sidebar { transform: translateX(-230px); }
                .sidebar.show { transform: translateX(0); }
                .main { margin-left: 0; }
                .user-info { display: none; }
            }
        </style>
        @stack('styles')
    </head>
    <body>

    <div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">K</div>
            <div class="brand">
                <span class="brand-title">Rapor Siswa</span>
                <span class="brand-sub">Panel Kepsek</span>
            </div>
        </div>

        <nav class="sidebar-menu">

            <a href="{{ route('kepsek.dashboard') }}" class="menu-item {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt icon"></i> Dashboard
            </a>

            <div class="menu-label">Penilaian</div>

            <a href="{{ route('kepsek.nilai.akhir') }}" class="menu-item {{ request()->routeIs('kepsek.nilai.akhir*') ? 'active' : '' }}">
                <i class="fa fa-star icon"></i> Nilai Akhir
            </a>

            <a href="{{ route('kepsek.kunci.nilai') }}" class="menu-item {{ request()->routeIs('kepsek.kunci.nilai') ? 'active' : '' }}">
                <i class="fa fa-lock icon"></i> Kunci Nilai
            </a>

            <div class="menu-label">Akun</div>

            <a href="{{ route('kepsek.profil') }}" class="menu-item {{ request()->routeIs('kepsek.profil') ? 'active' : '' }}">
                <i class="fa fa-user icon"></i> Profil Saya
            </a>

        </nav>

        <div class="sidebar-footer">
            &copy; {{ date('Y') }} Sistem Pengolahan Rapor Siswa
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main" id="main">
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="btn-toggle" onclick="toggleSidebar()">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <i class="fa fa-th-large"></i>
                    Sistem Pengolahan Rapor Siswa
                </div>
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

            @yield('content')
        </div>

        <footer>
            Copyright &copy; {{ date('Y') }} <a href="#">Sistem Pengolahan Rapor Siswa</a>
        </footer>
    </div>

    <script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const main    = document.getElementById('main');
        const overlay = document.getElementById('overlay');
        const isMobile = window.innerWidth <= 768;
        if (isMobile) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        }
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('show');
        document.getElementById('overlay').classList.remove('show');
    }
    function toggleMenu(btn, id) {
        const submenu = document.getElementById(id);
        const isOpen  = submenu.classList.contains('open');
        submenu.classList.toggle('open', !isOpen);
        btn.classList.toggle('open', !isOpen);
    }
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.getElementById('overlay').classList.remove('show');
            document.getElementById('sidebar').classList.remove('show');
        }
    });
    </script>
    @stack('scripts')
    </body>
    </html>