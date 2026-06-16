@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($kepsek) ? 'Edit Kepsek' : 'Tambah Kepsek' }}</div>

<div class="card" style="max-width:900px;margin:0 auto;">
    <div class="card-header">
        <span class="font-semibold">{{ isset($kepsek) ? 'Edit Data Kepala Sekolah' : 'Form Tambah Kepala Sekolah' }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($kepsek) ? route('admin.kepsek.update', $kepsek->id) : route('admin.kepsek.store') }}">
            @csrf
            @if(isset($kepsek)) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-500 @enderror"
                        value="{{ old('nama', $kepsek->nama ?? '') }}" required>
                    @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Jenis Kelamin --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                    <select name="jenis_kelamin"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin', $kepsek->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $kepsek->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">NIP</label>
                    <input type="text" name="nip"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('nip', $kepsek->nip ?? '') }}">
                </div>

                {{-- No HP --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">No. HP</label>
                    <input type="text" name="no_hp"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('no_hp', $kepsek->no_hp ?? '') }}">
                </div>

                {{-- Tempat Lahir --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('tempat_lahir', $kepsek->tempat_lahir ?? '') }}">
                </div>

                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('tanggal_lahir', isset($kepsek->tanggal_lahir) ? \Carbon\Carbon::parse($kepsek->tanggal_lahir)->format('Y-m-d') : '') }}">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                        value="{{ old('email', $kepsek->user->email ?? '') }}" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Password {{ isset($kepsek) ? '(kosongkan jika tidak diubah)' : '*' }}
                    </label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        {{ isset($kepsek) ? '' : 'required' }}>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Alamat --}}
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat', $kepsek->alamat ?? '') }}</textarea>
                </div>

            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($kepsek) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('admin.kepsek.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection