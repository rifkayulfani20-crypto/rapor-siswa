@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($mapel) ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran' }}</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">{{ isset($mapel) ? 'Edit Data Mata Pelajaran' : 'Form Tambah Mata Pelajaran' }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($mapel) ? route('mapel.update', $mapel->id) : route('mapel.store') }}">
            @csrf
            @if(isset($mapel)) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $mapel->nama ?? '') }}" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kode --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kode <span class="text-red-500">*</span></label>
                    <input type="text" name="kode"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('kode') border-red-500 @enderror"
                        value="{{ old('kode', $mapel->kode ?? '') }}" required>
                    @error('kode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Kelompok --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Kelompok</label>
                    <select name="kelompok"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Kelompok --</option>
                        <option value="A" {{ old('kelompok', $mapel->kelompok ?? '') == 'A' ? 'selected' : '' }}>A (Umum)</option>
                        <option value="B" {{ old('kelompok', $mapel->kelompok ?? '') == 'B' ? 'selected' : '' }}>B (Muatan Lokal)</option>
                        <option value="C" {{ old('kelompok', $mapel->kelompok ?? '') == 'C' ? 'selected' : '' }}>C (Peminatan)</option>
                    </select>
                </div>

                {{-- KKM --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">KKM <span class="text-red-500">*</span></label>
                    <input type="number" name="kkm" min="0" max="100"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('kkm') border-red-500 @enderror"
                        value="{{ old('kkm', $mapel->kkm ?? 75) }}" required>
                    @error('kkm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tahun Pelajaran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        @foreach($tapels as $tapel)
                            <option value="{{ $tapel->id }}" {{ old('tahun_pelajaran_id', $mapel->tahun_pelajaran_id ?? '') == $tapel->id ? 'selected' : '' }}>
                                {{ $tapel->nama }} - {{ $tapel->semester }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Guru --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Guru Pengampu</label>
                    <select name="guru_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Guru --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('guru_id', $mapel->guru_id ?? '') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($mapel) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('mapel.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection