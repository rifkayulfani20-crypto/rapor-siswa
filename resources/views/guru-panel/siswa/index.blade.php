@extends('layouts.guru')
@section('title', 'Data Siswa')
@section('content')
<div class="page-title">Data Siswa</div>
<div class="card">
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr><th>#</th><th>Nama</th><th>Kelas</th><th>NIS</th><th>Jenis Kelamin</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($siswas as $i => $siswa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td><span class="badge badge-success">{{ $siswa->status }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;">Tidak ada data siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection