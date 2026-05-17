<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login – sistem pengolahan rapor siswa </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: linear-gradient(135deg, #1a252f 0%, #2c3e50 60%, #3498db 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: #fff; border-radius: 12px; padding: 40px 36px; width: 380px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); }
        .login-header { text-align: center; margin-bottom: 28px; }
        .login-logo { width: 64px; height: 64px; background: #3498db; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .login-logo i { color: white; font-size: 28px; }
        .login-title { font-size: 20px; font-weight: 700; color: #2c3e50; }
        .login-subtitle { font-size: 13px; color: #7f8c8d; margin-top: 4px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #2c3e50; margin-bottom: 6px; }
        .input-group { position: relative; }
        .input-group i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #7f8c8d; font-size: 14px; }
        .form-control { width: 100%; padding: 10px 12px 10px 38px; border: 1.5px solid #ddd; border-radius: 6px; font-size: 14px; transition: border 0.2s; }
        .form-control:focus { outline: none; border-color: #3498db; }
        .is-invalid { border-color: #e74c3c !important; }
        .invalid-feedback { color: #e74c3c; font-size: 11px; margin-top: 4px; display: block; }
        .btn-login { width: 100%; padding: 11px; background: #3498db; color: white; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-login:hover { background: #2980b9; }
        .footer-text { text-align: center; font-size: 11px; color: #bdc3c7; margin-top: 20px; }
    </style>
</head>
<body>
<div class="login-box">
    <div class="login-header">
        <div class="login-logo"><i class="fa fa-graduation-cap"></i></div>
        <div class="login-title">sistem pengolahan rapor siswa</div>
        <div class="login-subtitle">Silakan masuk untuk melanjutkan</div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Email</label>
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" placeholder="admin@example.com" required>
            </div>
            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn-login"><i class="fa fa-sign-in-alt"></i> Masuk</button>
    </form>
    <div class="footer-text">Copyright &copy; 2023 MTs Rekayasa</div>
</div>
</body>
</html>