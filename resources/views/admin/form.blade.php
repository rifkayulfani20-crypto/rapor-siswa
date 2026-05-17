@extends('layouts.app')

@section('content')
<div class="page-title">Data Admin</div>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-{{ isset($adm) ? 'edit' : 'plus' }}"></i>
            {{ isset($adm) ? 'Edit Data Admin' : 'Tambah Data Admin' }}
        </span>
        <a href="{{ route('admin.index') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ isset($adm) ? route('admin.update', $adm->id) : route('admin.store') }}">
            @csrf
            @if(isset($adm)) @method('PUT') @endif

            <div class="form-row" style="grid-template-columns:1fr 1fr;gap:24px;">

                {{-- KOLOM KIRI --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('name', $adm->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email <span style="color:#e74c3c">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Masukkan email"
                               value="{{ old('email', $adm->email ?? '') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Password <span style="color:#e74c3c">*</span>
                            @if(isset($adm))
                                <small style="color:#7f8c8d;font-weight:400">(kosongkan jika tidak diubah)</small>
                            @endif
                        </label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="passwordInput"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   {{ isset($adm) ? '' : 'required' }}>
                            <button type="button" onclick="togglePassword()"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#7f8c8d;">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin', $adm->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $adm->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    <div class="form-group">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               placeholder="Masukkan NIP"
                               value="{{ old('nip', $adm->nip ?? '') }}">
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp"
                               class="form-control @error('no_hp') is-invalid @enderror"
                               placeholder="Masukkan no. HP"
                               value="{{ old('no_hp', $adm->no_hp ?? '') }}">
                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Masukkan alamat" rows="4">{{ old('alamat', $adm->alamat ?? '') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>

            <div style="display:flex;gap:8px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($adm) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.index') }}" class="btn btn-warning">
                    <i class="fa fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword() {
    const input = document.getElementById('passwordInput');
    const icon  = document.getElementById('eyeIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa fa-eye';
    }
}
</script>
@endpush