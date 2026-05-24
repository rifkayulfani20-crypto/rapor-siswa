@extends('layouts.siswa')
@section('content')

<h1 class="page-title">Profil Saya</h1>

<div class="card" style="max-width:600px">
    <div class="card-header"><i class="fa fa-user"></i> Data Diri</div>
    <div class="card-body">
        @php
        $rows = [
            'Nama Lengkap'      => $siswa->nama,
            'NIS'               => $siswa->nis,
            'NISN'              => $siswa->nisn,
            'Jenis Kelamin'     => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            'Tempat Lahir'      => $siswa->tempat_lahir ?? '-',
            'Tanggal Lahir'     => $siswa->tanggal_lahir?->format('d F Y') ?? '-',
            'Kelas'             => $siswa->kelas?->nama ?? '-',
            'Alamat'            => $siswa->alamat ?? '-',
            'Nama Ayah'         => $siswa->nama_ayah ?? '-',
            'Nama Ibu'          => $siswa->nama_ibu ?? '-',
            'No. HP Orang Tua'  => $siswa->no_hp_ortu ?? '-',
            'Status'            => $siswa->status,
        ];
        @endphp
        @foreach($rows as $label => $val)
        <div style="display:flex;padding:9px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
            <span style="width:160px;color:#7f8c8d;font-weight:600">{{ $label }}</span>
            <span style="color:#2c3e50">{{ $val }}</span>
        </div>
        @endforeach
    </div>
</div>

@endsection
