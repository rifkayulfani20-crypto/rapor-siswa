@extends('layouts.app')

@section('content')
<div class="page-title">Data Siswa</div>

<div class="card">
    <div class="card-header">
        <span><i class="fa fa-{{ isset($siswa) ? 'edit' : 'plus' }}"></i>
            {{ isset($siswa) ? 'Edit Data Siswa' : 'Tambah Data Siswa' }}
        </span>
        <a href="{{ route('siswa.index') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        <form method="POST" action="{{ isset($siswa) ? route('siswa.update', $siswa->id) : route('siswa.store') }}">
            @csrf
            @if(isset($siswa)) @method('PUT') @endif

            <div class="form-row" style="grid-template-columns:1fr 1fr;gap:24px;">

                {{-- KOLOM KIRI --}}
                <div>
                    {{-- Nama Lengkap --}}
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                               placeholder="Masukkan nama lengkap"
                               value="{{ old('nama', $siswa->nama ?? '') }}">
                        @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Kelas --}}
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Jenis Pendaftaran --}}
                    <div class="form-group">
                        <label class="form-label">Jenis Pendaftaran</label>
                        <select name="jenis_pendaftaran" class="form-control @error('jenis_pendaftaran') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Pendaftaran --</option>
                            <option value="Siswa Baru" {{ old('jenis_pendaftaran', $siswa->jenis_pendaftaran ?? '') == 'Siswa Baru' ? 'selected' : '' }}>Siswa Baru</option>
                            <option value="Siswa Pindahan" {{ old('jenis_pendaftaran', $siswa->jenis_pendaftaran ?? '') == 'Siswa Pindahan' ? 'selected' : '' }}>Siswa Pindahan</option>
                        </select>
                        @error('jenis_pendaftaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Diterima Pada --}}
                    <div class="form-group">
                        <label class="form-label">Diterima Pada</label>
                        <input type="date" name="diterima_pada" class="form-control @error('diterima_pada') is-invalid @enderror"
                               value="{{ old('diterima_pada', isset($siswa->diterima_pada) ? \Carbon\Carbon::parse($siswa->diterima_pada)->format('Y-m-d') : '') }}">
                        @error('diterima_pada')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- NIS --}}
                    <div class="form-group">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror"
                               placeholder="Masukkan NIS"
                               value="{{ old('nis', $siswa->nis ?? '') }}">
                        @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- NISN --}}
                    <div class="form-group">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror"
                               placeholder="Masukkan NISN"
                               value="{{ old('nisn', $siswa->nisn ?? '') }}">
                        @error('nisn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                               placeholder="Masukkan tempat lahir"
                               value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
                        @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}">
                        @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Agama --}}
                    <div class="form-group">
                        <label class="form-label">Agama</label>
                        <select name="agama" class="form-control @error('agama') is-invalid @enderror">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $ag)
                            <option value="{{ $ag }}" {{ old('agama', $siswa->agama ?? '') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                            @endforeach
                        </select>
                        @error('agama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="Aktif" {{ old('status', $siswa->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $siswa->status ?? '') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                            <option value="Lulus" {{ old('status', $siswa->status ?? '') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- KOLOM KANAN --}}
                <div>
                    {{-- Anak ke --}}
                    <div class="form-group">
                        <label class="form-label">Anak ke</label>
                        <input type="number" name="anak_ke" class="form-control @error('anak_ke') is-invalid @enderror"
                               placeholder="Masukkan anak ke"
                               value="{{ old('anak_ke', $siswa->anak_ke ?? '') }}">
                        @error('anak_ke')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Masukkan alamat" rows="3">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
                        @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="form-group">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                               placeholder="Masukkan telepon"
                               value="{{ old('telepon', $siswa->telepon ?? '') }}">
                        @error('telepon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nama Ayah --}}
                    <div class="form-group">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control @error('nama_ayah') is-invalid @enderror"
                               placeholder="Masukkan nama ayah"
                               value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}">
                        @error('nama_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pekerjaan Ayah --}}
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" class="form-control @error('pekerjaan_ayah') is-invalid @enderror"
                               placeholder="Masukkan pekerjaan ayah"
                               value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah ?? '') }}">
                        @error('pekerjaan_ayah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nama Ibu --}}
                    <div class="form-group">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control @error('nama_ibu') is-invalid @enderror"
                               placeholder="Masukkan nama ibu"
                               value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}">
                        @error('nama_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pekerjaan Ibu --}}
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" class="form-control @error('pekerjaan_ibu') is-invalid @enderror"
                               placeholder="Masukkan pekerjaan ibu"
                               value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu ?? '') }}">
                        @error('pekerjaan_ibu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nama Wali --}}
                    <div class="form-group">
                        <label class="form-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror"
                               placeholder="Masukkan nama wali"
                               value="{{ old('nama_wali', $siswa->nama_wali ?? '') }}">
                        @error('nama_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Pekerjaan Wali --}}
                    <div class="form-group">
                        <label class="form-label">Pekerjaan Wali</label>
                        <input type="text" name="pekerjaan_wali" class="form-control @error('pekerjaan_wali') is-invalid @enderror"
                               placeholder="Masukkan pekerjaan wali"
                               value="{{ old('pekerjaan_wali', $siswa->pekerjaan_wali ?? '') }}">
                        @error('pekerjaan_wali')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

            </div>{{-- end form-row --}}

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;margin-top:8px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($siswa) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('siswa.index') }}" class="btn btn-warning">
                    <i class="fa fa-times"></i> Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection