<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya – Kepala Sekolah</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>tailwind.config = { corePlugins: { preflight: false } }</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; display: flex; min-height: 100vh; }
        .sidebar { width: 230px; background: #ffffff; display: flex; flex-direction: column; min-height: 100vh; position: fixed; top: 0; left: 0; z-index: 100; border-right: 1px solid #e0e0e0; }
        .sidebar-header { padding: 16px 15px; background: #f5f5f5; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e0e0e0; }
        .sidebar-header .logo { width: 36px; height: 36px; background: #1a3a6c; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 15px; color: white; flex-shrink: 0; }
        .sidebar-header .brand { display: flex; flex-direction: column; }
        .sidebar-header .brand-title { font-weight: 700; font-size: 13px; color: #2c3e50; line-height: 1.2; }
        .sidebar-header .brand-sub { font-size: 10px; color: #999; margin-top: 2px; }
        .sidebar-menu { flex: 1; padding: 10px 0; overflow-y: auto; }
        .menu-label { font-size: 10px; text-transform: uppercase; color: #aaa; padding: 12px 15px 4px; letter-spacing: 1px; font-weight: 600; }
        .menu-item { display: flex; align-items: center; gap: 10px; padding: 10px 15px; color: #555; text-decoration: none; font-size: 13px; cursor: pointer; transition: background 0.2s; border: none; background: none; width: 100%; text-align: left; }
        .menu-item:hover { background: #f0f4fb; color: #1a3a6c; }
        .menu-item.active { background: #1a3a6c; color: #ffffff; }
        .menu-item i.icon { width: 17px; text-align: center; font-size: 13px; }
        .sidebar-footer { padding: 10px 15px; border-top: 1px solid #eee; font-size: 11px; color: #bbb; text-align: center; }
        .main { margin-left: 230px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { background: #fff; padding: 0 22px; height: 56px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 1px 4px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 50; }
        .topbar-title { font-size: 14px; font-weight: 600; color: #2c3e50; display: flex; align-items: center; gap: 8px; }
        .topbar-title i { color: #1a3a6c; }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .user-name { font-size: 13px; font-weight: 600; color: #2c3e50; line-height: 1.2; }
        .user-role { font-size: 10px; color: #999; }
        .avatar { width: 32px; height: 32px; background: #1a3a6c; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 13px; font-weight: bold; flex-shrink: 0; }
        .btn-logout { background: #e74c3c; color: white; border: none; padding: 6px 13px; border-radius: 5px; font-size: 12px; cursor: pointer; display: flex; align-items: center; gap: 5px; transition: background 0.2s; }
        .btn-logout:hover { background: #c0392b; }
        .content { padding: 24px; flex: 1; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(26,58,108,0.12); margin-bottom: 20px; overflow: hidden; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 11px; font-weight: 700; color: #1a3a6c; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 9px 12px 9px 36px; border: 1.5px solid #dce3ea; border-radius: 8px; background: #f5f7f9; font-size: 13px; color: #2c3e50; outline: none; transition: border 0.2s; }
        .form-control:focus { border-color: #1a3a6c; background: #fff; }
        .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        footer { background: #fff; padding: 12px 24px; text-align: center; font-size: 12px; color: #aaa; border-top: 1px solid #eee; }
        footer a { color: #1a3a6c; text-decoration: none; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo">K</div>
        <div class="brand">
            <span class="brand-title">Rapor Siswa</span>
            <span class="brand-sub">Kepala Sekolah</span>
        </div>
    </div>
    <nav class="sidebar-menu">
        <a href="{{ route('kepsek.dashboard') }}" class="menu-item">
            <i class="fa fa-tachometer-alt icon"></i> Dashboard
        </a>
        <div class="menu-label">Kelola Nilai</div>
        <a href="{{ route('kepsek.dashboard') }}" class="menu-item">
            <i class="fa fa-lock icon"></i> Kunci Nilai
        </a>
        <div class="menu-label">Akun</div>
        <a href="{{ route('profil.index') }}" class="menu-item active">
            <i class="fa fa-user icon"></i> Profil Saya
        </a>
    </nav>
    <div class="sidebar-footer">&copy; {{ date('Y') }} Rapor Siswa</div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title">
            <i class="fa fa-user"></i> Profil Saya
        </div>
        <div class="topbar-right">
            <div style="display:flex;flex-direction:column;align-items:flex-end;">
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
            <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        <div style="max-width:600px;">

            {{-- Avatar Card --}}
            <div class="card">
                <div style="background:linear-gradient(135deg,#1a3a6c 0%,#122a52 100%);padding:24px 28px;display:flex;align-items:center;gap:20px;">
                    <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,0.15);border:3px solid rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;color:white;font-size:28px;font-weight:bold;flex-shrink:0;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:20px;font-weight:700;color:#fff;margin-bottom:6px;">{{ $user->name }}</div>
                        <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.25);margin-bottom:6px;">
                            <i class="fa fa-user-tie" style="margin-right:4px;"></i>Kepala Sekolah
                        </span>
                        <div style="font-size:12px;color:rgba(255,255,255,0.7);display:flex;align-items:center;gap:6px;">
                            <i class="fa fa-envelope"></i> {{ $user->email }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="card">
                <div style="background:linear-gradient(90deg,#1a3a6c,#122a52);padding:14px 22px;">
                    <div style="font-weight:600;color:#fff;font-size:14px;display:flex;align-items:center;gap:8px;">
                        <i class="fa fa-user-edit"></i> Edit Profil
                    </div>
                </div>
                <div style="padding:28px 24px;">
                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf @method('PUT')

                        <div class="form-group">
                            <label class="form-label"><i class="fa fa-user" style="margin-right:4px;"></i> Nama Lengkap</label>
                            <div style="position:relative;">
                                <i class="fa fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fa fa-envelope" style="margin-right:4px;"></i> Email</label>
                            <div style="position:relative;">
                                <i class="fa fa-envelope" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Masukkan email">
                            </div>
                        </div>

                        <div style="display:flex;align-items:center;gap:12px;margin:24px 0 8px;">
                            <div style="flex:1;height:1px;background:#dce3ea;"></div>
                            <span style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;">
                                <i class="fa fa-lock" style="margin-right:4px;"></i> Ubah Password
                            </span>
                            <div style="flex:1;height:1px;background:#dce3ea;"></div>
                        </div>
                        <p style="font-size:12px;color:#90a4ae;margin-bottom:16px;">Kosongkan jika tidak ingin mengubah password.</p>

                        <div class="form-group">
                            <label class="form-label"><i class="fa fa-lock" style="margin-right:4px;"></i> Password Baru</label>
                            <div style="position:relative;">
                                <i class="fa fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                                <input type="password" name="password" id="pass1" class="form-control" style="padding-right:40px;" placeholder="Min. 6 karakter">
                                <span onclick="toggle('pass1','eye1')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#90a4ae;">
                                    <i class="fa fa-eye" id="eye1"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fa fa-lock" style="margin-right:4px;"></i> Konfirmasi Password</label>
                            <div style="position:relative;">
                                <i class="fa fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                                <input type="password" name="password_confirmation" id="pass2" class="form-control" style="padding-right:40px;" placeholder="Ulangi password baru">
                                <span onclick="toggle('pass2','eye2')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#90a4ae;">
                                    <i class="fa fa-eye" id="eye2"></i>
                                </span>
                            </div>
                        </div>

                        <div style="margin-top:24px;">
                            <button type="submit" style="background:linear-gradient(135deg,#1a3a6c,#122a52);color:#fff;border:none;padding:10px 28px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px;">
                                <i class="fa fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer>
        Copyright &copy; {{ date('Y') }} <a href="#">Sistem Pengolahan Rapor Siswa</a>
    </footer>
</div>

<script>
function toggle(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>