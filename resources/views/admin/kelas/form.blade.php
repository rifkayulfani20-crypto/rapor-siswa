@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($kelas) && $kelas ? 'Edit Kelas' : 'Tambah Kelas' }}</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">{{ isset($kelas) && $kelas ? 'Edit Data Kelas' : 'Form Tambah Kelas' }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($kelas) && $kelas ? route('kelas.update', $kelas->id) : route('kelas.store') }}">
            @csrf
            @if(isset($kelas) && $kelas) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">

                {{-- Nama Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: IX A"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $kelas->nama ?? '') }}" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tingkat --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tingkat <span class="text-red-500">*</span></label>
                    <select name="tingkat"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Tingkat --</option>
                        <option value="VII" {{ old('tingkat', $kelas->tingkat ?? '') == 'VII' ? 'selected' : '' }}>VII</option>
                        <option value="VIII" {{ old('tingkat', $kelas->tingkat ?? '') == 'VIII' ? 'selected' : '' }}>VIII</option>
                        <option value="IX" {{ old('tingkat', $kelas->tingkat ?? '') == 'IX' ? 'selected' : '' }}>IX</option>
                    </select>
                    @error('tingkat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Wali Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Wali Kelas</label>
                    <select name="wali_kelas_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($gurus as $guru)
                            <option value="{{ $guru->id }}" {{ old('wali_kelas_id', $kelas->wali_kelas_id ?? '') == $guru->id ? 'selected' : '' }}>
                                {{ $guru->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tahun Pelajaran --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <select name="tahun_pelajaran_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        @foreach($tapels as $tapel)
                            <option value="{{ $tapel->id }}" {{ old('tahun_pelajaran_id', $kelas->tahun_pelajaran_id ?? '') == $tapel->id ? 'selected' : '' }}>
                                {{ $tapel->nama }} - {{ $tapel->semester }}
                            </option>
                        @endforeach
                    </select>
                    @error('tahun_pelajaran_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($kelas) && $kelas ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('kelas.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection