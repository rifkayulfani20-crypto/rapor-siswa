@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')
@section('page-title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="flex flex-col items-center justify-center py-20 text-center">
    <div class="text-8xl font-black text-blue-100 mb-4">404</div>
    <h2 class="text-2xl font-bold text-gray-700 mb-2">Halaman Tidak Ditemukan</h2>
    <p class="text-gray-500 mb-6">Halaman yang Anda cari tidak ada atau sudah dipindahkan.</p>
    <a href="{{ route('dashboard') }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold transition">
        &larr; Kembali ke Dashboard
    </a>
</div>
@endsection
```