@extends('layouts.app')
@section('title', 'Nilai Akhir')
@section('content')

<div class="page-title">Data Nilai Akhir</div>

<div class="card">
    <div class="card-body">

        <div class="table-wrapper">
            <table id="nilaiakhirTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $i => $k)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $k->nama ?? '-' }}</td>
                        <td>{{ optional($k->waliKelas)->nama ?? '-' }}</td>
                        <td>{{ optional($k->tahunPelajaran)->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('nilai.akhir.detail', $k->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-list"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:30px;color:#7f8c8d;">
                            Tidak ada data kelas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px;">
            {{ $kelas->links() }}
        </div>

    </div>
</div>

@endsection