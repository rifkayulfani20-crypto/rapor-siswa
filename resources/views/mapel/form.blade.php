@extends('layouts.app')
@section('title', isset($mapel) ? 'Edit Mapel' : 'Tambah Mapel')
@section('page-title', isset($mapel) ? 'Edit Mapel' : 'Tambah Mapel')
@section('content')

<div class="page-title">{{ isset($mapel) ? 'Edit Mapel' : 'Tambah Mapel' }}</div>

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <div>{{ isset($mapel) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</div>
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

        <form method="POST" action="{{ isset($mapel) ? route('mapel.update', $mapel) : route('mapel.store') }}">
            @csrf
            @if(isset($mapel)) @method('PUT') @endif

            {{-- Tahun Pelajaran --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Pelajaran *</label>
                <select name="tahun_pelajaran_id"
                    class="form-control @error('tahun_pelajaran_id') is-invalid @enderror">
                    <option value="">-- Pilih Tahun Pelajaran --</option>
                    @foreach($tapels as $tp)
                        <option value="{{ $tp->id }}"
                            {{ old('tahun_pelajaran_id', $mapel->tahun_pelajaran_id ?? '') == $tp->id ? 'selected' : '' }}>
                            {{ $tp->nama }}
                        </option>
                    @endforeach
                </select>
                @error('tahun_pelajaran_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nama Mata Pelajaran --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Mata Pelajaran *</label>
                <input type="text" name="nama"
                    class="form-control @error('nama') is-invalid @enderror"
                    value="{{ old('nama', $mapel->nama ?? '') }}"
                    placeholder="Contoh: Matematika" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Kode / Singkatan --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kode / Singkatan *</label>
                <input type="text" name="kode"
                    class="form-control @error('kode') is-invalid @enderror"
                    value="{{ old('kode', $mapel->kode ?? '') }}"
                    placeholder="Contoh: MTK" required>
                @error('kode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- KKM --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">KKM *</label>
                <input type="number" name="kkm" min="0" max="100"
                    class="form-control @error('kkm') is-invalid @enderror"
                    value="{{ old('kkm', $mapel->kkm ?? 75) }}">
                @error('kkm')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Guru Pengampu --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Guru Pengampu</label>
                <select name="guru_id" class="form-control">
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                        <option value="{{ $guru->id }}"
                            {{ old('guru_id', $mapel->guru_id ?? '') == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol --}}
            <div style="display:flex; gap:8px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection