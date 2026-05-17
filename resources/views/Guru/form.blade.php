@extends('layouts.app')

@section('content')
<div class="page-title">Data Guru</div>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-{{ isset($guru) ? 'edit' : 'plus' }}"></i>
            {{ isset($guru) ? 'Edit Data Guru' : 'Tambah Data Guru' }}
        </span>
        <a href="{{ route('guru.index') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ isset($guru) ? route('guru.update', $guru) : route('guru.store') }}">
            @csrf
            @if(isset($guru)) @method('PUT') @endif

            <div class="form-row" style="grid-template-columns:1fr 1fr;gap:24px;">

                {{-- KOLOM KIRI --}}
                <div>
                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span style="color:#e74c3c">*</span></label>
                        <input type="text" name="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('nama', $guru->nama ?? '') }}" required>
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- NIP --}}
                    <div class="form-group">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               placeholder="Masukkan NIP"
                               value="{{ old('nip', $guru->nip ?? '') }}">
                        @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- NUPTK --}}
                    <div class="form-group">
                        <label class="form-label">NUPTK</label>
                        <input type="text" name="nuptk"
                               class="form-control @error('nuptk') is-invalid @enderror"
                               placeholder="Masukkan NUPTK"
                               value="{{ old('nuptk', $guru->nuptk ?? '') }}">
                        @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin <span style="color:#e74c3c">*</span></label>
                        <div style="display:flex;gap:20px;margin-top:6px;">
                            <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                                <input type="radio" name="jenis_kelamin" value="L"
                                       {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }}>
                                Laki-laki
                            </label>
                            <label style="display:flex;align-items:center;gap:6px;font-size:13px;cursor:pointer;">
                                <input type="radio" name="jenis_kelamin" value="P"
                                       {{ old('jenis_kelamin', $guru->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }}>
                                Perempuan
                            </label>
                        </div>
                        @error('jenis_kelamin')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               placeholder="Masukkan tempat lahir"
                               value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}">
                        @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', isset($guru->tanggal_lahir) ? \Carbon\Carbon::parse($guru->tanggal_lahir)->format('Y-m-d') : '') }}">
                        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Agama --}}
                    <div class="form-group">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-control @error('agama') is-invalid @enderror">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $ag)
                            <option value="{{ $ag }}" {{ old('agama', $guru->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                        @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    {{-- No. HP --}}
                    <div class="form-group">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp"
                               class="form-control @error('no_hp') is-invalid @enderror"
                               placeholder="Masukkan no. HP"
                               value="{{ old('no_hp', $guru->no_hp ?? '') }}">
                        @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label">Email <span style="color:#e74c3c">*</span></label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="Masukkan email"
                               value="{{ old('email', $guru->user->email ?? '') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label">
                            Password <span style="color:#e74c3c">*</span>
                            @if(isset($guru))
                                <small style="color:#7f8c8d;font-weight:400">(kosongkan jika tidak diubah)</small>
                            @endif
                        </label>
                        <div style="position:relative;">
                            <input type="password" name="password" id="passwordInput"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Masukkan password"
                                   {{ isset($guru) ? '' : 'required' }}>
                            <button type="button" onclick="togglePassword()"
                                    style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#7f8c8d;font-size:13px;">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')<div class="invalid-feedback" style="display:block">{{ $message }}</div>@enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Masukkan alamat" rows="3">{{ old('alamat', $guru->alamat ?? '') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jabatan --}}
                    <div class="form-group">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan"
                               class="form-control @error('jabatan') is-invalid @enderror"
                               placeholder="Masukkan jabatan"
                               value="{{ old('jabatan', $guru->jabatan ?? '') }}">
                        @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pendidikan Terakhir --}}
                    <div class="form-group">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan" class="form-control @error('pendidikan') is-invalid @enderror">
                            <option value="">-- Pilih Pendidikan --</option>
                            @foreach(['SMA/SMK','D1','D2','D3','S1','S2','S3'] as $p)
                            <option value="{{ $p }}" {{ old('pendidikan', $guru->pendidikan ?? '') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        @error('pendidikan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Aktif"      {{ old('status', $guru->status ?? 'Aktif') == 'Aktif'      ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $guru->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>{{-- end form-row --}}

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($guru) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('guru.index') }}" class="btn btn-warning">
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