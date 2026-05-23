@extends('layouts.guru')
@section('title', 'Data Kelas')
@section('content')

<div class="page-title">Data Kelas Saya</div>

<div class="card">
    <div class="card-body">
        <div class="table-toolbar">
            <label class="small">Tampilkan
                <select class="per-page">
                    <option>10</option><option>25</option><option>50</option>
                </select> entri
            </label>
            <input type="search" class="search-box" placeholder="Search...">
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelass as $i => $kelas)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $kelas->nama }}</td>
                        <td>{{ $kelas->waliKelas->nama ?? '-' }}</td>
                        <td>{{ $kelas->tahunPelajaran->nama ?? '-' }}</td>
                        <td style="text-align:right;">
                            <a href="{{ route('guru.walikelas.kelas', $kelas->id) }}"
                               class="btn btn-success btn-sm">
                                <i class="fas fa-list"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:#7f8c8d;">
                            Tidak ada data kelas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection