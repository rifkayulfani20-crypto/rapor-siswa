@extends('layouts.app')

@section('content')
<div class="page-title">Edit Akun</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">Edit Data Akun</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.akun.update', $akun->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('name') border-red-500 @enderror"
                        value="{{ old('name', $akun->name) }}" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Username --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input type="text" name="username"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('username') border-red-500 @enderror"
                        value="{{ old('username', $akun->username) }}">
                    @error('username') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('email') border-red-500 @enderror"
                        value="{{ old('email', $akun->email) }}">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password (kosongkan jika tidak diubah)</label>
                    <input type="password" name="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;margin-top:20px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-save"></i> Update
                </button>
                <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>
    </div>
</div>
@endsection