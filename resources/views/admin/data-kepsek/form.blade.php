@extends('layouts.app')

@section('content')
<div class="page-title">{{ isset($kepsek) ? 'Edit Kepala Sekolah' : 'Tambah Kepala Sekolah' }}</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">{{ isset($kepsek) ? 'Edit Akun Kepala Sekolah' : 'Form Tambah Kepala Sekolah' }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($kepsek) ? route('kepsek-user.update', $kepsek) : route('kepsek-user.store') }}">
            @csrf
            @if(isset($kepsek)) @method('PUT') @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror"
                        value="{{ old('name', $kepsek->name ?? '') }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                        value="{{ old('email', $kepsek->email ?? '') }}" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Password {{ isset($kepsek) ? '(kosongkan jika tidak diubah)' : '*' }}
                    </label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                        {{ isset($kepsek) ? '' : 'required' }}>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> {{ isset($kepsek) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('kepsek-user.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection