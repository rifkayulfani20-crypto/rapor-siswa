@extends('layouts.siswa')
@section('content')

<h1 class="page-title">Dashboard</h1>

{{-- Alert login berhasil --}}
@if(session('success'))
<div class="alert alert-success" style="display:flex;align-items:center;justify-content:space-between">
    <span><i class="fa fa-check-circle"></i> Anda berhasil login sebagai <strong>SISWA</strong></span>
    <button onclick="this.parentElement.remove()" style="background:none;border:none;cursor:pointer;font-size:16px">&times;</button>
</div>
@endif

{{-- 2 Card utama --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px">
    <a href="{{ route('siswa.nilai') }}" style="text-decoration:none">
        <div style="background:linear-gradient(135deg,#1a3a6c,#1e4d8c);color:white;border-radius:10px;padding:30px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 12px rgba(26,58,108,0.4)">
            <div>
                <div style="font-size:22px;font-weight:700;margin-bottom:6px">Nilai</div>
                <div style="font-size:13px;opacity:0.85">Nilai Akhir</div>
                <div style="margin-top:16px;font-size:12px;opacity:0.9">Lihat detail &rsaquo;</div>
            </div>
            <i class="fa fa-star" style="font-size:60px;opacity:0.3"></i>
        </div>
    </a>

    <a href="{{ route('siswa.raport') }}" style="text-decoration:none">
        <div style="background:linear-gradient(135deg,#1e4d8c,#2563b0);color:white;border-radius:10px;padding:30px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 12px rgba(30,77,140,0.4)">
            <div>
                <div style="font-size:22px;font-weight:700;margin-bottom:6px">Raport</div>
                <div style="font-size:13px;opacity:0.85">Cetak Raport</div>
                <div style="margin-top:16px;font-size:12px;opacity:0.9">Lihat detail &rsaquo;</div>
            </div>
            <i class="fa fa-clipboard-list" style="font-size:60px;opacity:0.3"></i>
        </div>
    </a>
</div>

{{-- Info Siswa --}}
<div class="card" style="max-width:500px">
    <div class="card-header" style="background:linear-gradient(90deg,#1a3a6c,#1e4d8c);color:#fff;border-radius:8px 8px 0 0;">
        <i class="fa fa-user"></i> Informasi Siswa
    </div>
    <div class="card-body" style="font-size:13px">
        @php
        $rows = [
            'Nama'            => $siswa->nama,
            'NIS'             => $siswa->nis,
            'NISN'            => $siswa->nisn,
            'Kelas'           => $siswa->kelas?->nama ?? '-',
            'Jenis Kelamin'   => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            'Tahun Pelajaran' => $tapel?->nama ?? '-',
        ];
        @endphp
        @foreach($rows as $label => $val)
        <div style="display:flex;padding:8px 0;border-bottom:1px solid #f0f0f0">
            <span style="width:130px;color:#7f8c8d">{{ $label }}</span>
            <span style="font-weight:600;color:#1a3a6c">{{ $val }}</span>
        </div>
        @endforeach
    </div>
</div>

@endsection