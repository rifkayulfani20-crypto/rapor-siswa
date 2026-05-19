@extends('layouts.guru')
@section('content')
<h1 class="page-title">Dashboard</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 gap-4 mb-6">

    <div class="bg-[#3498db] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_siswa }}</div>
            <div class="text-sm mt-1 opacity-80">Siswa</div>
            <a href="{{ route('guru.siswa.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-user-graduate text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#f39c12] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_guru }}</div>
            <div class="text-sm mt-1 opacity-80">Guru</div>
            <span class="text-white/70 text-xs">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-users text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#27ae60] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_ekskul }}</div>
            <div class="text-sm mt-1 opacity-80">Ekstrakurikuler</div>
            <span class="text-white/70 text-xs">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-running text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#e74c3c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_mapel }}</div>
            <div class="text-sm mt-1 opacity-80">Mata Pelajaran</div>
            <span class="text-white/70 text-xs">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-book text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#95a5a6] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_kelas }}</div>
            <div class="text-sm mt-1 opacity-80">Kelas</div>
            <span class="text-white/70 text-xs">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-door-open text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#17a2b8] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $persen }}%</div>
            <div class="text-sm mt-1 opacity-80">Penilaian Selesai</div>
            <span class="text-white/70 text-xs">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-check-circle text-5xl opacity-25"></i>
    </div>

</div>

{{-- Info Panel --}}
<div class="card">
    <div class="card-header">
        <span class="bg-[#27ae60] text-white px-3 py-1 rounded text-sm font-semibold">
            <i class="fa fa-bullhorn"></i> Informasi
        </span>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="flex gap-3 items-start px-5 py-4 border-b border-gray-100">
            <div class="w-9 h-9 bg-[#3498db] rounded-full flex items-center justify-center text-white shrink-0">
                <i class="fa fa-envelope text-sm"></i>
            </div>
            <div>
                <div class="text-sm font-semibold text-[#2c3e50]">{{ auth()->user()->name }}</div>
                <div class="text-xs text-gray-400 mt-1">Selamat datang di e-Raport MTs Rekayasa</div>
            </div>
        </div>
    </div>
</div>
@endsection