@extends('layouts.guru')
@section('title', 'Dashboard Guru')
@section('content')

<div class="page-title">Dashboard</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:16px; margin-bottom:24px;">

    <div style="background:#3498db; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_siswa }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Siswa</div>
            <a href="{{ route('guru.siswa.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail ›</a>
        </div>
        <i class="fas fa-user-graduate" style="font-size:48px; opacity:.25;"></i>
    </div>

    <div style="background:#f39c12; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_guru }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Guru</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail ›</span>
        </div>
        <i class="fas fa-users" style="font-size:48px; opacity:.25;"></i>
    </div>

    <div style="background:#27ae60; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_ekskul }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Ekstrakurikuler</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail ›</span>
        </div>
        <i class="fas fa-running" style="font-size:48px; opacity:.25;"></i>
    </div>

    <div style="background:#e74c3c; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_mapel }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Mata Pelajaran</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail ›</span>
        </div>
        <i class="fas fa-book" style="font-size:48px; opacity:.25;"></i>
    </div>

    <div style="background:#95a5a6; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_kelas }}</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Kelas</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail ›</span>
        </div>
        <i class="fas fa-door-open" style="font-size:48px; opacity:.25;"></i>
    </div>

    <div style="background:#17a2b8; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $persen }}%</div>
            <div style="font-size:13px; opacity:.85; margin-top:4px;">Penilaian Selesai</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail ›</span>
        </div>
        <i class="fas fa-check-circle" style="font-size:48px; opacity:.25;"></i>
    </div>

</div>

{{-- Info Panel --}}
<div class="card">
    <div class="card-header">
        <span style="background:#27ae60; color:white; padding:4px 12px; border-radius:4px; font-size:13px; font-weight:600;">
            <i class="fas fa-bullhorn"></i> Informasi
        </span>
    </div>
    <div class="card-body" style="padding:0;">
        <div style="display:flex; gap:12px; align-items:flex-start; padding:16px 20px; border-bottom:1px solid #eee;">
            <div style="width:36px; height:36px; background:#3498db; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-envelope" style="color:white; font-size:14px;"></i>
            </div>
            <div>
                <div style="font-size:13px; font-weight:600; color:#2c3e50;">{{ auth()->user()->name }}</div>
                <div style="font-size:12px; color:#7f8c8d; margin-top:4px;">Selamat datang di e-Raport MTs Rekayasa</div>
            </div>
        </div>
    </div>
</div>

@endsection