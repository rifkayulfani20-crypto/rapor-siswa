@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($tapel) && $tapel ? 'Edit Tahun Pelajaran' : 'Tambah Tahun Pelajaran' }}</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">{{ isset($tapel) && $tapel ? 'Edit Data Tahun Pelajaran' : 'Form Tambah Tahun Pelajaran' }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($tapel) && $tapel ? route('tapel.update', $tapel->id) : route('tapel.store') }}">
            @csrf
            @if(isset($tapel) && $tapel) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Tahun Pelajaran <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" placeholder="Contoh: 2024/2025"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $tapel->nama ?? '') }}" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Semester --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Semester <span class="text-red-500">*</span></label>
                    <select name="semester"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ganjil" {{ old('semester', $tapel->semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                        <option value="Genap" {{ old('semester', $tapel->semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tempat Pembagian --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Pembagian</label>
                    <input type="text" name="tempat_pembagian"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('tempat_pembagian', $tapel->tempat_pembagian ?? '') }}">
                </div>

                {{-- Tanggal Pembagian --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pembagian</label>
                    <input type="date" name="tanggal_pembagian"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('tanggal_pembagian', isset($tapel->tanggal_pembagian) ? \Carbon\Carbon::parse($tapel->tanggal_pembagian)->format('Y-m-d') : '') }}">
                </div>

                {{-- Aktif --}}
                <div class="col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="aktif" value="1"
                            {{ old('aktif', $tapel->aktif ?? false) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-500">
                        <span class="text-sm font-medium text-gray-600">Jadikan Tahun Pelajaran Aktif</span>
                    </label>
                </div>

            </div>

            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($tapel) && $tapel ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('tapel.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection