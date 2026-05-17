@extends('layouts.app')
@section('title', isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas')
@section('page-title', isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas')
@section('content')

<div class="page-title">{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Data Kelas' }}</div>

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <div>{{ isset($kelas) ? 'Edit Data Kelas' : 'Tambah Data Kelas' }}</div>
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

        <form method="POST" action="{{ isset($kelas) ? route('kelas.update', $kelas) : route('kelas.store') }}">
            @csrf
            @if(isset($kelas)) @method('PUT') @endif

            {{-- Nama Kelas --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kelas *</label>
                <input type="text" name="nama"
                       class="form-control @error('nama') is-invalid @enderror"
                       value="{{ old('nama', $kelas->nama ?? '') }}"
                       placeholder="Contoh: IX A" required>
                @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Tingkat --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tingkat *</label>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    @foreach(['VII','VIII','IX'] as $t)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tingkat"
                               id="tingkat{{ $t }}" value="{{ $t }}"
                               {{ old('tingkat', $kelas->tingkat ?? 'VII') == $t ? 'checked' : '' }}>
                        <label class="form-check-label" for="tingkat{{ $t }}">Kelas {{ $t }}</label>
                    </div>
                    @endforeach
                </div>
                @error('tingkat')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>

            {{-- Tahun Pelajaran --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Pelajaran *</label>
                <select name="tahun_pelajaran_id"
                        class="form-control @error('tahun_pelajaran_id') is-invalid @enderror">
                    <option value="">-- Pilih Tahun Pelajaran --</option>
                    @foreach($tapels as $tapel)
                    <option value="{{ $tapel->id }}"
                        {{ old('tahun_pelajaran_id', $kelas->tahun_pelajaran_id ?? '') == $tapel->id ? 'selected' : '' }}>
                        {{ $tapel->nama }} - {{ $tapel->semester }}{{ $tapel->aktif ? ' (Aktif)' : '' }}
                    </option>
                    @endforeach
                </select>
                @error('tahun_pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Wali Kelas --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Wali Kelas</label>
                <select name="wali_kelas_id" class="form-control">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}"
                        {{ old('wali_kelas_id', $kelas->wali_kelas_id ?? '') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection