@extends('layouts.siswa')

@section('title', 'Rapor')

@section('content')
<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:60vh; text-align:center; padding:20px;">
    <div style="width:80px; height:80px; background:#fef3c7; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px;">
        <i class="fa fa-hourglass-half" style="font-size:32px; color:#d97706;"></i>
    </div>
    <h2 style="font-size:18px; font-weight:700; color:#1a3a6c; margin-bottom:8px;">Rapor Belum Siap</h2>
    <p style="font-size:14px; color:#64748b; max-width:400px; line-height:1.6;">
        Nilai untuk semester ini masih dalam proses input oleh guru dan
        belum difinalisasi oleh Kepala Sekolah. Rapor akan bisa dilihat
        dan dicetak setelah proses penilaian selesai.
    </p>
    <a href="{{ route('siswa.dashboard') }}" style="margin-top:20px; padding:10px 20px; background:#1a3a6c; color:#fff; border-radius:8px; text-decoration:none; font-size:13px; font-weight:600;">
        <i class="fa fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
@endsection