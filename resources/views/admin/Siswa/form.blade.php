@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:14px;color:#2c3e50;">
            <i class="fa fa-user-graduate" style="color:#1a3a6c;margin-right:6px;"></i>
            {{ isset($siswa) ? 'Edit Data Siswa' : 'Form Tambah Siswa' }}
        </span>
        <a href="{{ route('siswa.index') }}" class="btn btn-sm" style="background:#ddd;color:#555;">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom:16px;">
            <i class="fa fa-exclamation-circle"></i>
            <ul style="margin:0;padding-left:16px;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ isset($siswa) ? route('siswa.update', $siswa->id) : route('siswa.store') }}">
            @csrf
            @if(isset($siswa)) @method('PUT') @endif

                 SECTION 1: AKUN LOGIN
            <div style="background:#eaf4fb;border:1px solid #bee3f8;border-radius:8px;padding:16px 20px;margin-bottom:20px;">
                <div style="font-weight:700;font-size:13px;color:#1a5276;margin-bottom:14px;display:flex;align-items:center;gap:7px;">
                    <i class="fa fa-key"></i> Akun Login Siswa
                    @if(isset($siswa))
                        <span style="font-size:11px;font-weight:400;color:#555;">
                            — Email saat ini: <strong>{{ $siswa->user?->email ?? '-' }}</strong>
                        </span>
                    @endif
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">

                    {{-- Email --}}
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">
                            Email <span style="color:red;">*</span>
                            @if(isset($siswa))<span style="font-weight:400;color:#888;">(kosongkan jika tidak diubah)</span>@endif
                        </label>
                        <div style="position:relative;">
                            <i class="fa fa-envelope" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:12px;"></i>
                            <input type="email" name="email"
                                placeholder="contoh@email.com"
                                {{ !isset($siswa) ? 'required' : '' }}
                                value="{{ old('email', $siswa->user?->email ?? '') }}"
                                style="width:100%;padding:8px 10px 8px 32px;border:1px solid #bee3f8;border-radius:6px;font-size:13px;outline:none;background:#fff;box-sizing:border-box;">
                        </div>
                        @error('email')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">
                            Password <span style="color:red;">*</span>
                            @if(isset($siswa))<span style="font-weight:400;color:#888;">(kosongkan jika tidak diubah)</span>@endif
                        </label>
                        <div style="position:relative;">
                            <i class="fa fa-lock" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:12px;"></i>
                            <input type="password" name="password" id="pwField"
                                placeholder="{{ isset($siswa) ? '••••••••' : 'Min. 6 karakter' }}"
                                {{ !isset($siswa) ? 'required' : '' }}
                                style="width:100%;padding:8px 34px 8px 32px;border:1px solid #bee3f8;border-radius:6px;font-size:13px;outline:none;background:#fff;box-sizing:border-box;">
                            <span onclick="togglePw()" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#aaa;">
                                <i class="fa fa-eye" id="pwIcon"></i>
                            </span>
                        </div>
                        @error('password')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                    </div>

                </div>
                @if(!isset($siswa))
                <p style="font-size:11px;color:#666;margin-top:8px;"><i class="fa fa-info-circle"></i> Email dan password ini digunakan siswa untuk login ke sistem.</p>
                @endif
            </div>

  
                 SECTION 2: DATA PRIBADI
            <div style="font-weight:700;font-size:13px;color:#1a3a6c;margin-bottom:12px;border-bottom:2px solid #e8edf2;padding-bottom:8px;">
                <i class="fa fa-id-card"></i> Data Pribadi
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">

                {{-- Nama --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Nama Lengkap <span style="color:red;">*</span></label>
                    <input type="text" name="nama" required
                        value="{{ old('nama', $siswa->nama ?? '') }}"
                        placeholder="Nama lengkap siswa"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                    @error('nama')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                {{-- NIS --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">NIS <span style="color:red;">*</span></label>
                    <input type="tel" name="nis" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required
                        value="{{ old('nis', $siswa->nis ?? '') }}"
                        placeholder="Nomor Induk Siswa"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                    @error('nis')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                {{-- NISN --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">NISN</label>
                    <input type="tel" name="nisn" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        value="{{ old('nisn', $siswa->nisn ?? '') }}"
                        placeholder="Nomor Induk Siswa Nasional"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                    @error('nisn')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Jenis Kelamin <span style="color:red;">*</span></label>
                    <select name="jenis_kelamin" required
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;background:#fff;box-sizing:border-box;">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir"
                        value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}"
                        placeholder="Kota kelahiran"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

                {{-- Kelas --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Kelas</label>
                    <select name="kelas_id"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;background:#fff;box-sizing:border-box;">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas ?? $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Status <span style="color:red;">*</span></label>
                    <select name="status" required
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;background:#fff;box-sizing:border-box;">
                        <option value="Aktif"    {{ old('status', $siswa->status ?? 'Aktif') == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                        <option value="Nonaktif" {{ old('status', $siswa->status ?? '')       == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                {{-- Alamat --}}
                <div style="grid-column:span 2;">
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Alamat</label>
                    <textarea name="alamat" rows="2"
                        placeholder="Alamat lengkap siswa"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                </div>

            </div>

                 SECTION 3: DATA ORANG TUA
            <div style="font-weight:700;font-size:13px;color:#1a3a6c;margin-bottom:12px;border-bottom:2px solid #e8edf2;padding-bottom:8px;">
                <i class="fa fa-users"></i> Data Orang Tua / Wali
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:24px;">

                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}"
                        placeholder="Nama ayah kandung"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}"
                        placeholder="Nama ibu kandung"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali ?? '') }}"
                        placeholder="Jika diasuh wali"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">No. HP Orang Tua</label>
                    <input type="tel" name="no_hp_ortu" pattern="[0-9]*" inputmode="numeric" oninput="this.value=this.value.replace(/[^0-9]/g,'')" value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}"
                        placeholder="08xxxxxxxxxx"
                        style="width:100%;padding:8px 10px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                </div>

            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid #eee;">
                <button type="submit"
                    style="background:#1a3a6c;color:#fff;border:none;padding:10px 24px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:7px;">
                    <i class="fa fa-save"></i> {{ isset($siswa) ? 'Update Data' : 'Simpan Data' }}
                </button>
                <a href="{{ route('siswa.index') }}"
                    style="background:#ddd;color:#555;padding:10px 20px;border-radius:7px;font-size:13px;text-decoration:none;display:flex;align-items:center;gap:7px;">
                    <i class="fa fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
function togglePw() {
    const input = document.getElementById('pwField');
    const icon  = document.getElementById('pwIcon');
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
@endsection