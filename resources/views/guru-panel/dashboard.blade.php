@extends('layouts.guru')
@section('title', 'Dashboard Guru')
@section('content')

<div class="page-title">Dashboard</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px; margin-bottom:24px;">

    {{-- Guru --}}
    <div style="background:#1a3353; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:18px; font-weight:700; line-height:1.3;">{{ auth()->user()->name }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Guru</div>
            <a href="{{ route('guru.profil') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat profil ›</a>
        </div>
        <i class="fas fa-users" style="font-size:48px; opacity:.25;"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div style="background:#122540; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_mapel }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Mata Pelajaran</div>
            <a href="{{ route('guru.mapel.nilai') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail ›</a>
        </div>
        <i class="fas fa-book" style="font-size:48px; opacity:.25;"></i>
    </div>

    {{-- Kelas --}}
    <div style="background:#0f1f36; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_kelas }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Kelas</div>
            <a href="{{ route('guru.walikelas.kelas') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail ›</a>
        </div>
        <i class="fas fa-door-open" style="font-size:48px; opacity:.25;"></i>
    </div>

    {{-- Penilaian Selesai --}}
    <div style="background:#0a1628; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $persen }}%</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Penilaian Selesai</div>
            <a href="{{ route('guru.nilaiakhir') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail ›</a>
        </div>
        <i class="fas fa-check-circle" style="font-size:48px; opacity:.25;"></i>
    </div>

</div>

@endsection