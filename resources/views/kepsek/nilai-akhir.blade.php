@extends('layouts.kepsek_app')

@section('content')
<div class="page-title">Nilai Akhir Siswa</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:14px;"><i class="fa fa-star"></i> Daftar Kelas</span>
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->nama }}</td>
                        <td>{{ $k->waliKelas->nama ?? '-' }}</td>
                        <td>{{ $k->tahunPelajaran->nama ?? '-' }} {{ $k->tahunPelajaran->semester ?? '' }}</td>
                        <td><span class="badge badge-info">{{ $k->siswas->count() }} Siswa</span></td>
                        <td>
                            <a href="{{ route('kepsek.nilai.akhir.detail', $k->id) }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i> Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data kelas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection