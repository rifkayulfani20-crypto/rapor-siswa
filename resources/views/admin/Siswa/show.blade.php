@extends('layouts.app')

@section('content')
<div class="page-title">Detail Siswa</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">{{ $siswa->nama }}</span>
        <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <table class="table-detail">
            <tr><th>Nama</th><td>{{ $siswa->nama }}</td></tr>
            <tr><th>NIS</th><td>{{ $siswa->nis }}</td></tr>
            <tr><th>NISN</th><td>{{ $siswa->nisn ?? '-' }}</td></tr>
            <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
            <tr><th>Tempat, Tgl Lahir</th><td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('j F Y') : '-' }}</td></tr>
            <tr><th>Kelas</th><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>
            <tr><th>Alamat</th><td>{{ $siswa->alamat ?? '-' }}</td></tr>
            <tr><th>Nama Ayah</th><td>{{ $siswa->nama_ayah ?? '-' }}</td></tr>
            <tr><th>Nama Ibu</th><td>{{ $siswa->nama_ibu ?? '-' }}</td></tr>
            <tr><th>Nama Wali</th><td>{{ $siswa->nama_wali ?? '-' }}</td></tr>
            <tr><th>No. HP Ortu</th><td>{{ $siswa->no_hp_ortu ?? '-' }}</td></tr>
            <tr><th>Status</th><td>
                <span class="badge {{ $siswa->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                    {{ strtoupper($siswa->status) }}
                </span>
            </td></tr>
        </table>
    </div>
</div>
@endsection