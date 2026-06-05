@extends('layouts.guru')
@section('title', 'Dashboard Guru')
@section('content')

<div class="page-title">Dashboard</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 gap-4 mb-6">

    {{-- Guru (Profil) --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold leading-snug">{{ auth()->user()->name }}</div>
            <div class="text-sm opacity-85 mt-1">Guru</div>
            <a href="{{ route('guru.profil') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat profil ›</a>
        </div>
        <i class="fas fa-chalkboard-teacher text-5xl opacity-25"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_mapel }}</div>
            <div class="text-sm opacity-85 mt-1">Mata Pelajaran</div>
            <a href="{{ route('guru.mapel.nilai') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-book text-5xl opacity-25"></i>
    </div>

    {{-- Kelas --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_kelas }}</div>
            <div class="text-sm opacity-85 mt-1">Kelas</div>
            <a href="{{ route('guru.walikelas.kelas') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-door-open text-5xl opacity-25"></i>
    </div>

    {{-- Penilaian Selesai --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $persen }}%</div>
            <div class="text-sm opacity-85 mt-1">Penilaian Selesai</div>
            <a href="{{ route('guru.nilaiakhir') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-check-circle text-5xl opacity-25"></i>
    </div>

</div>

@endsection