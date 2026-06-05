@extends('layouts.guru')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('content')

<div class="page-title">Profil Saya</div>

<div style="max-width:600px;">

    {{-- Avatar Card --}}
    <div class="card mb-3" style="border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(26,58,108,0.15); border:none;">
        <div style="background:linear-gradient(135deg,#1a3a6c 0%,#122a52 100%); padding:24px 28px; display:flex; align-items:center; gap:20px; position:relative; overflow:hidden;">
            <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-40px;left:80px;width:150px;height:150px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

            <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,0.15);border:3px solid rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;color:white;font-size:28px;font-weight:bold;flex-shrink:0;position:relative;z-index:1;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div style="position:relative;z-index:1;">
                <div style="font-size:20px;font-weight:700;color:#fff;margin-bottom:6px;">
                    {{ auth()->user()->name }}
                </div>
                <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.25);margin-bottom:6px;">
                    <i class="fa fa-shield-alt" style="margin-right:4px;"></i>{{ ucfirst(auth()->user()->role) }}
                </span>
                <div style="font-size:12px;color:rgba(255,255,255,0.7);display:flex;align-items:center;gap:6px;">
                    <i class="fa fa-envelope"></i> {{ auth()->user()->email }}
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card" style="border-radius:12px;border:none;box-shadow:0 4px 20px rgba(26,58,108,0.12);overflow:hidden;">

        <div class="card-header" style="background:linear-gradient(90deg,#1a3a6c,#122a52);border:none;padding:14px 22px;">
            <div style="font-weight:600;color:#fff;font-size:14px;display:flex;align-items:center;gap:8px;">
                <i class="fa fa-user-edit"></i> Edit Profil
            </div>
        </div>

        <div class="card-body" style="padding:28px 24px;">

            @if($errors->any())
                <div class="alert alert-danger" style="border-radius:8px;border-left:4px solid #e74c3c;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('guru.profil.update') }}">
                @csrf @method('PUT')

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;">
                        <i class="fa fa-user" style="margin-right:4px;"></i> Nama Lengkap
                    </label>
                    <div style="position:relative;">
                        <i class="fa fa-user" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               style="padding-left:36px;border:1.5px solid #dce3ea;border-radius:8px;background:#f5f7f9;font-size:13px;"
                               value="{{ old('name', auth()->user()->name) }}"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;">
                        <i class="fa fa-envelope" style="margin-right:4px;"></i> Email
                    </label>
                    <div style="position:relative;">
                        <i class="fa fa-envelope" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               style="padding-left:36px;border:1.5px solid #dce3ea;border-radius:8px;background:#f5f7f9;font-size:13px;"
                               value="{{ old('email', auth()->user()->email) }}"
                               placeholder="Masukkan email">
                    </div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Divider --}}
                <div style="display:flex;align-items:center;gap:12px;margin:24px 0 8px;">
                    <div style="flex:1;height:1px;background:#dce3ea;"></div>
                    <span style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;white-space:nowrap;">
                        <i class="fa fa-lock" style="margin-right:4px;"></i> Ubah Password
                    </span>
                    <div style="flex:1;height:1px;background:#dce3ea;"></div>
                </div>
                <p style="font-size:12px;color:#90a4ae;margin-bottom:16px;">Kosongkan jika tidak ingin mengubah password.</p>

                {{-- Password Baru --}}
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;">
                        <i class="fa fa-lock" style="margin-right:4px;"></i> Password Baru
                    </label>
                    <div style="position:relative;">
                        <i class="fa fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                        <input type="password" name="password" id="pass1"
                               class="form-control @error('password') is-invalid @enderror"
                               style="padding-left:36px;padding-right:40px;border:1.5px solid #dce3ea;border-radius:8px;background:#f5f7f9;font-size:13px;"
                               placeholder="Min. 6 karakter">
                        <span onclick="toggle('pass1','eye1')"
                              style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#90a4ae;font-size:14px;">
                            <i class="fa fa-eye" id="eye1"></i>
                        </span>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label class="form-label" style="font-size:11px;font-weight:700;color:#1a3a6c;text-transform:uppercase;letter-spacing:0.6px;">
                        <i class="fa fa-lock" style="margin-right:4px;"></i> Konfirmasi Password
                    </label>
                    <div style="position:relative;">
                        <i class="fa fa-lock" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#90a4ae;font-size:13px;"></i>
                        <input type="password" name="password_confirmation" id="pass2"
                               class="form-control"
                               style="padding-left:36px;padding-right:40px;border:1.5px solid #dce3ea;border-radius:8px;background:#f5f7f9;font-size:13px;"
                               placeholder="Ulangi password baru">
                        <span onclick="toggle('pass2','eye2')"
                              style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#90a4ae;font-size:14px;">
                            <i class="fa fa-eye" id="eye2"></i>
                        </span>
                    </div>
                </div>

                {{-- Tombol --}}
                <div style="margin-top:24px;">
                    <button type="submit" class="btn"
                            style="background:linear-gradient(135deg,#1a3a6c,#122a52);color:#fff;border:none;padding:10px 28px;border-radius:8px;font-size:14px;font-weight:600;box-shadow:0 4px 12px rgba(26,58,108,0.35);display:inline-flex;align-items:center;gap:8px;">
                        <i class="fa fa-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
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

@endsection