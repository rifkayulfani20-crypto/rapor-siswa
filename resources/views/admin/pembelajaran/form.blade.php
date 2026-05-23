@extends('layouts.app')
@section('title', isset($item) ? 'Edit Pembelajaran' : 'Tambah Pembelajaran')
@section('page-title', isset($item) ? 'Edit Pembelajaran' : 'Tambah Pembelajaran')
@section('content')

<div class="page-title">{{ isset($item) ? 'Edit Pembelajaran' : 'Tambah Pembelajaran' }}</div>

<div class="card" style="max-width:600px;">
    <div class="card-header">
        <div>{{ isset($item) ? 'Edit Data Pembelajaran' : 'Tambah Data Pembelajaran' }}</div>
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

        <form method="POST" action="{{ isset($item) ? route('pembelajaran.update', $item) : route('pembelajaran.store') }}">
            @csrf
            @if(isset($item)) @method('PUT') @endif

            {{-- Guru --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Guru *</label>
                <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Guru --</option>
                    @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}"
                        {{ old('guru_id', $item->guru_id ?? '') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->nama }}
                    </option>
                    @endforeach
                </select>
                @error('guru_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Mata Pelajaran --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Mata Pelajaran *</label>
                <select name="mata_pelajaran_id" class="form-control @error('mata_pelajaran_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach($mapels as $mapel)
                    <option value="{{ $mapel->id }}"
                        {{ old('mata_pelajaran_id', $item->mata_pelajaran_id ?? '') == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama }}
                    </option>
                    @endforeach
                </select>
                @error('mata_pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Kelas --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Kelas *</label>
                <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ old('kelas_id', $item->kelas_id ?? '') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama }}
                    </option>
                    @endforeach
                </select>
                @error('kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Tahun Pelajaran --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Pelajaran *</label>
                <select name="tahun_pelajaran_id" class="form-control @error('tahun_pelajaran_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Tahun Pelajaran --</option>
                    @foreach($tapels as $tapel)
                    <option value="{{ $tapel->id }}"
                        {{ old('tahun_pelajaran_id', $item->tahun_pelajaran_id ?? '') == $tapel->id ? 'selected' : '' }}>
                        {{ $tapel->nama }}{{ $tapel->aktif ? ' (Aktif)' : '' }}
                    </option>
                    @endforeach
                </select>
                @error('tahun_pelajaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-control">
                    <option value="Aktif"    {{ old('status', $item->status ?? 'Aktif') == 'Aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ old('status', $item->status ?? '')      == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>
                <a href="{{ route('pembelajaran.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection