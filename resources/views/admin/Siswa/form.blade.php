@extends('layouts.app')

@section('content')
<div class="text-2xl font-bold text-gray-700 mb-6">{{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}</div>

<div class="bg-white rounded-xl shadow p-6">
    <div class="flex items-center justify-between mb-6 pb-3 border-b">
        <span class="font-semibold text-gray-700">{{ isset($siswa) ? 'Edit Data Siswa' : 'Form Tambah Siswa' }}</span>
    </div>

    <form method="POST" action="{{ isset($siswa) ? route('siswa.update', $siswa->id) : route('siswa.store') }}">
        @csrf
        @if(isset($siswa)) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror"
                    value="{{ old('nama', $siswa->nama ?? '') }}" required>
                @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- NIS --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">NIS <span class="text-red-500">*</span></label>
                <input type="text" name="nis"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nis') border-red-500 @enderror"
                    value="{{ old('nis', $siswa->nis ?? '') }}" required>
                @error('nis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- NISN --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">NISN</label>
                <input type="text" name="nisn"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nisn') border-red-500 @enderror"
                    value="{{ old('nisn', $siswa->nisn ?? '') }}">
                @error('nisn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tempat Lahir --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Lahir</label>
                <input type="text" name="tempat_lahir"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('tempat_lahir', $siswa->tempat_lahir ?? '') }}">
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('tanggal_lahir', isset($siswa->tanggal_lahir) ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('Y-m-d') : '') }}">
            </div>

            {{-- Kelas --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Kelas</label>
                <select name="kelas_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
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
                <label class="block text-sm font-medium text-gray-600 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    <option value="Aktif" {{ old('status', $siswa->status ?? 'Aktif') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ old('status', $siswa->status ?? '') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat', $siswa->alamat ?? '') }}</textarea>
            </div>

            {{-- Nama Ayah --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Ayah</label>
                <input type="text" name="nama_ayah"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('nama_ayah', $siswa->nama_ayah ?? '') }}">
            </div>

            {{-- Nama Ibu --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Ibu</label>
                <input type="text" name="nama_ibu"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('nama_ibu', $siswa->nama_ibu ?? '') }}">
            </div>

            {{-- Nama Wali --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Wali</label>
                <input type="text" name="nama_wali"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('nama_wali', $siswa->nama_wali ?? '') }}">
            </div>

            {{-- No HP Ortu --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">No. HP Orang Tua</label>
                <input type="text" name="no_hp_ortu"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('no_hp_ortu', $siswa->no_hp_ortu ?? '') }}">
            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex gap-3 mt-6 pt-4 border-t">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa fa-save mr-1"></i> {{ isset($siswa) ? 'Update' : 'Simpan' }}
            </button>
            <a href="{{ route('siswa.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition">
                <i class="fa fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

    </form>
</div>
@endsection