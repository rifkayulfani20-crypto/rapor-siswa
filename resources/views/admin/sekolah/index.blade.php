@extends('layouts.app')
@section('title','Data Sekolah')
@section('page-title','Data Sekolah')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Edit Data Sekolah -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 text-sm mb-5 pb-3 border-b border-gray-200">Edit Data Sekolah</h3>
        <form method="POST" action="{{ route('admin.sekolah.update', $sekolah) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Sekolah</label>
                <input type="text" name="nama" value="{{ old('nama', $sekolah->nama) }}"
                       placeholder="MTs Rekayasa"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">NPSN</label>
                <input type="text" name="npsn" value="{{ old('npsn', $sekolah->npsn) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">NSS</label>
                <input type="text" name="nss" value="{{ old('nss', $sekolah->nss) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Kode POS</label>
                <input type="text" name="kode_pos" value="{{ old('kode_pos', $sekolah->kode_pos) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $sekolah->telepon) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400"
                          placeholder="Masukkan alamat">{{ old('alamat', $sekolah->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $sekolah->email) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Website</label>
                <input type="text" name="website" value="{{ old('website', $sekolah->website) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Kepala Sekolah</label>
                <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $sekolah->kepala_sekolah) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>
            <div class="mb-3">
                <label class="block text-xs font-semibold text-gray-600 mb-1">NIP Kepala Sekolah</label>
                <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $sekolah->nip_kepala_sekolah) }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
            </div>

            <div class="flex items-center gap-2 mt-1 mb-4">
                <input type="checkbox" id="yakin" class="w-4 h-4 text-blue-600 rounded">
                <label for="yakin" class="text-xs text-gray-600">Saya yakin akan mengubah data tersebut</label>
            </div>

            <button type="submit"
                    onclick="return document.getElementById('yakin').checked || (alert('Centang persetujuan dulu!') && false)"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                <i class="fas fa-save mr-1"></i> Simpan
            </button>
        </form>
    </div>

    <!-- Edit Logo Sekolah -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 text-sm mb-5 pb-3 border-b border-gray-200">Edit Logo Sekolah</h3>

        <div class="flex items-center justify-center border border-gray-200 rounded-lg h-44 mb-4 bg-gray-50">
            @if($sekolah->logo)
                <img src="{{ asset('storage/'.$sekolah->logo) }}" class="h-36 object-contain" alt="Logo Sekolah">
            @else
                <div class="text-center text-gray-400">
                    <i class="fas fa-image text-5xl mb-2 block"></i>
                    <p class="text-sm">Logo</p>
                </div>
            @endif
        </div>

        <p class="text-xs text-gray-500 mb-3">Ganti logo sekolah</p>

        <form method="POST" action="{{ route('admin.sekolah.update', $sekolah) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <input type="hidden" name="nama" value="{{ $sekolah->nama }}">
            <div class="flex gap-2">
                <input type="file" name="logo" accept="image/*"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-blue-400">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                    Update
                </button>
            </div>
        </form>
    </div>

</div>
@endsection