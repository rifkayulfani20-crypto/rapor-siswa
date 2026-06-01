@extends('layouts.app')

@section('content')
<h1 class="page-title">Dashboard</h1>

{{-- Grid Kartu --}}
<div class="grid grid-cols-2 gap-4 mb-6">

    {{-- Siswa --}}
    <div class="bg-[#1e3a5f] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_siswa }}</div>
            <div class="text-sm opacity-85 mt-1">Siswa</div>
            <a href="{{ route('siswa.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-user-graduate text-5xl opacity-25"></i>
    </div>

    {{-- Guru --}}
    <div class="bg-[#1a3353] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_guru }}</div>
            <div class="text-sm opacity-85 mt-1">Guru</div>
            <a href="{{ route('guru.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-users text-5xl opacity-25"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div class="bg-[#162d47] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_mapel }}</div>
            <div class="text-sm opacity-85 mt-1">Mata Pelajaran</div>
            <a href="{{ route('mapel.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-book text-5xl opacity-25"></i>
    </div>

    {{-- Kelas --}}
    <div class="bg-[#122540] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_kelas }}</div>
            <div class="text-sm opacity-85 mt-1">Kelas</div>
            <a href="{{ route('kelas.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-door-open text-5xl opacity-25"></i>
    </div>

    {{-- Penilaian Selesai --}}
    @php
        $persen = ($total_siswa > 0 && $total_mapel > 0)
            ? round(($nilai_sudah_diinput ?? 0) / ($total_siswa * $total_mapel) * 100)
            : 53;
    @endphp
    <div class="bg-[#0f1f36] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $persen }}%</div>
            <div class="text-sm opacity-85 mt-1">Penilaian Selesai</div>
            <a href="{{ route('nilai.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-check-circle text-5xl opacity-25"></i>
    </div>

</div>



@endsection