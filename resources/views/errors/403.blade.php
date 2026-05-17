@extends('layouts.app')
@section('title', 'Akses Ditolak')
@section('page-title', 'Akses Ditolak')

@section('content')
<div class="flex flex-col items-center justify-center py-20 text-center">
    <div class="text-8xl font-black text-red-200 mb-4">403</div>
    <h2 class="text-2xl font-bold text-gray-700 mb-2">Akses Ditolak</h2>
    <p class="text-gray-500 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="{{ route('dashboard') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
        &larr; Kembali ke Dashboard
    </a>
</div>
@endsection
```