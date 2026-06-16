@extends('layouts.kepsek_app')

@section('content')
<div class="page-title">Detail Nilai Akhir - {{ $kelas->nama }}</div>

<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:14px;">
            <i class="fa fa-users"></i>
            {{ $kelas->nama }} &mdash; {{ $kelas->tahunPelajaran->nama ?? '' }} {{ $kelas->tahunPelajaran->semester ?? '' }}
        </span>
        <a href="{{ route('kepsek.nilai.akhir') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Jumlah Nilai</th>
                        <th>Rata-rata</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $i => $siswa)
                        @php
                            $nilaiSiswa = $nilais->get($siswa->id, collect());
                            $jumlah     = $nilaiSiswa->count();
                            $rata       = $jumlah > 0 ? round($nilaiSiswa->avg('nilai_akhir'), 1) : 0;
                        @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis ?? '-' }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $jumlah }} mapel</td>
                            <td>
                                <strong style="color: {{ $rata >= 75 ? '#27ae60' : '#e74c3c' }}">
                                    {{ $rata > 0 ? $rata : '-' }}
                                </strong>
                            </td>
                            <td>
                                @if($rata >= 75)
                                    <span class="badge badge-success">Lulus</span>
                                @elseif($rata > 0)
                                    <span class="badge badge-danger">Tidak Lulus</span>
                                @else
                                    <span class="badge badge-warning">Belum Ada Nilai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:#7f8c8d;padding:40px">
                                <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada siswa di kelas ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection