@extends('layouts.guru')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('content')

<div class="page-title">Profil Saya</div>

<div style="max-width:600px;">

    {{-- Avatar Card --}}
    <div class="card mb-3">
        <div class="card-body" style="display:flex;align-items:center;gap:20px;">
            <div style="width:64px;height:64px;border-radius:50%;background:#3498db;display:flex;align-items:center;justify-content:center;color:white;font-size:26px;font-weight:bold;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:18px;font-weight:700;color:#2c3e50;">{{ auth()->user()->name }}</div>
                <div style="margin-top:4px;">
                    <span style="padding:2px 10px;border-radius:4px;font-size:12px;font-weight:600;background:#e8f0fe;color:#1a56db;">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
                <div style="font-size:12px;color:#7f8c8d;margin-top:4px;">
                    {{ auth()->user()->email }}
                </div>
            </div>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="card">
        <div class="card-header">
            <div style="font-weight:600;">Edit Profil</div>
        </div>
        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
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
                    <label class="form-label">
                        <i class="fa fa-user"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', auth()->user()->name) }}"
                           placeholder="Masukkan nama lengkap">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">
                        <i class="fa fa-envelope"></i> Email
                    </label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', auth()->user()->email) }}"
                           placeholder="Masukkan email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                {{-- Divider --}}
                <hr style="margin:20px 0;">
                <div style="font-weight:600;font-size:13px;margin-bottom:12px;">
                    <i class="fa fa-lock"></i> Ubah Password
                    <span style="font-weight:400;color:#7f8c8d;">(kosongkan jika tidak ingin diubah)</span>
                </div>

                {{-- Password Baru --}}
                <div class="form-group">
                    <label class="form-label">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="pass1"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter">
                        <span onclick="toggle('pass1','eye1')"
                              style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#7f8c8d;">
                            <i class="fa fa-eye" id="eye1"></i>
                        </span>
                    </div>
                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="pass2"
                               class="form-control"
                               placeholder="Ulangi password baru">
                        <span onclick="toggle('pass2','eye2')"
                              style="position:absolute;right:12px;top:50%;transform:translateY(-50%);cursor:pointer;color:#7f8c8d;">
                            <i class="fa fa-eye" id="eye2"></i>
                        </span>
                    </div>
                </div>

                {{-- Tombol --}}
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan Perubahan
                </button>

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