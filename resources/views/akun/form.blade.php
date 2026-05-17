@extends('layouts.app')

@section('content')
<div class="page-title">Data Akun</div>

<div class="card" style="max-width:700px;">
    <div class="card-header">
        <div>Edit Data Akun</div>
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

        <form action="{{ route('admin.akun.update', $akun->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div style="display:flex;align-items:center;margin-bottom:16px;gap:16px;">
                <label style="width:160px;font-weight:500;margin:0;">Nama</label>
                <input type="text" name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $akun->name . ' - ' . ucfirst($akun->role)) }}"
                       placeholder="Nama lengkap" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Username --}}
            <div style="display:flex;align-items:center;margin-bottom:16px;gap:16px;">
                <label style="width:160px;font-weight:500;margin:0;">Username</label>
                <input type="text" name="username"
                       class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username', $akun->username) }}"
                       placeholder="Username">
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Email --}}
            <div style="display:flex;align-items:center;margin-bottom:16px;gap:16px;">
                <label style="width:160px;font-weight:500;margin:0;">
                    Email <span style="font-weight:400;color:#888;">(Opsional)</span>
                </label>
                <input type="email" name="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $akun->email) }}"
                       placeholder="Email">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Password --}}
            <div style="display:flex;align-items:center;margin-bottom:16px;gap:16px;">
                <label style="width:160px;font-weight:500;margin:0;">
                    Password <span style="font-weight:400;color:#888;">(opsional)</span>
                </label>
                <input type="password" name="password" id="passwordInput"
                       class="form-control @error('password') is-invalid @enderror"
                       placeholder="Masukkan password baru">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Checkbox konfirmasi --}}
            <div style="display:flex;align-items:center;margin-bottom:20px;gap:16px;">
                <label style="width:160px;margin:0;"></label>
                <div style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" name="konfirmasi" id="konfirmasi" value="1">
                    <label for="konfirmasi" style="margin:0;cursor:pointer;">
                        Saya yakin akan mengubah data tersebut
                    </label>
                </div>
            </div>

            {{-- Tombol --}}
            <div style="display:flex;align-items:center;gap:16px;">
                <label style="width:160px;margin:0;"></label>
                <button type="submit" class="btn btn-primary" id="btnSimpan" disabled
                        style="background:#20c997;border-color:#20c997;min-width:90px;">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

<script>
// Tombol simpan hanya aktif jika checkbox dicentang
document.getElementById('konfirmasi').addEventListener('change', function () {
    document.getElementById('btnSimpan').disabled = !this.checked;
});
</script>
@endsection