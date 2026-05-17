@extends('layouts.app')

@section('content')
<h1 class="page-title">Dashboard</h1>

<div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">

    {{-- Siswa --}}
    <div style="background:#3498db; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_siswa }}</div>
            <div style="font-size:14px; opacity:.85;">Siswa</div>
            <a href="{{ route('siswa.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-user-graduate" style="font-size:50px; opacity:.25;"></i>
    </div>

    {{-- Guru --}}
    <div style="background:#f39c12; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_guru }}</div>
            <div style="font-size:14px; opacity:.85;">Guru</div>
            <a href="{{ route('guru.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-users" style="font-size:50px; opacity:.25;"></i>
    </div>

    {{-- Ekstrakurikuler --}}
    <div style="background:#27ae60; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">5</div>
            <div style="font-size:14px; opacity:.85;">Ekstrakurikuler</div>
            <span style="color:rgba(255,255,255,.7); font-size:12px;">Lihat detail &rsaquo;</span>
        </div>
        <i class="fa fa-running" style="font-size:50px; opacity:.25;"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div style="background:#e74c3c; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_mapel }}</div>
            <div style="font-size:14px; opacity:.85;">Mata Pelajaran</div>
            <a href="{{ route('mapel.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-book" style="font-size:50px; opacity:.25;"></i>
    </div>

    {{-- Kelas --}}
    <div style="background:#95a5a6; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $total_kelas }}</div>
            <div style="font-size:14px; opacity:.85;">Kelas</div>
            <a href="{{ route('kelas.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-door-open" style="font-size:50px; opacity:.25;"></i>
    </div>

    {{-- Penilaian Selesai --}}
    @php
        $persen = ($total_siswa > 0 && $total_mapel > 0)
            ? round(($nilai_sudah_diinput ?? 0) / ($total_siswa * $total_mapel) * 100)
            : 53;
    @endphp
    <div style="background:#17a2b8; color:white; border-radius:10px; padding:20px; display:flex; align-items:center; justify-content:space-between;">
        <div>
            <div style="font-size:36px; font-weight:700;">{{ $persen }}%</div>
            <div style="font-size:14px; opacity:.85;">Penilaian Selesai</div>
            <a href="{{ route('nilai.index') }}" style="color:rgba(255,255,255,.7); font-size:12px; text-decoration:none;">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-check-circle" style="font-size:50px; opacity:.25;"></i>
    </div>
</div>

{{-- Info Panel --}}
<div class="card">
    <div class="card-header">
        <span style="background:#27ae60; color:white; padding:4px 12px; border-radius:4px; font-size:13px; font-weight:600;">
            <i class="fa fa-bullhorn"></i> Informasi
        </span>
        <span style="font-size:13px; color:#3498db; cursor:pointer;">+ Informasi</span>
    </div>
    <div class="card-body" style="padding:0;">
        <div style="padding:14px 20px; border-bottom:1px solid #f0f0f0; display:flex; gap:12px; align-items:flex-start;">
            <div style="width:36px; height:36px; background:#3498db; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; flex-shrink:0;">
                <i class="fa fa-envelope" style="font-size:14px;"></i>
            </div>
            <div>
                <div style="font-size:13px; font-weight:600; color:#2c3e50;">{{ auth()->user()->name }}</div>
                <div style="font-size:12px; color:#7f8c8d;">Tolong segera perbaiki data siswa!</div>
                <div style="margin-top:6px;"><span style="background:#f0f0f0; color:#2c3e50; padding:3px 10px; border-radius:4px; font-size:11px; cursor:pointer;">Lihat detail</span></div>
            </div>
        </div>
    </div>
</div>
@endsection