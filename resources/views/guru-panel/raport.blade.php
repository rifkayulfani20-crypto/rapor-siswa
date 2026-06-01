@extends('layouts.guru')
@section('title', 'Raport Siswa')
@section('content')

<div class="page-title">Raport Siswa</div>

@forelse($kelass as $kelas)
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <div style="font-weight:600;"><i class="fas fa-school"></i> Kelas {{ $kelas->nama }}
            <span style="font-weight:400;font-size:13px;color:#7f8c8d;"> — {{ $kelas->tahunPelajaran->tahun_pelajaran ?? '-' }} Sem. {{ $kelas->tahunPelajaran->semester ?? '-' }}</span>
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <table style="width:100%;border-collapse:collapse;font-size:13px;">
            <thead>
                <tr style="background:#2c3e50;color:#fff;">
                    <th style="padding:10px 14px;text-align:left;width:40px;">#</th>
                    <th style="padding:10px 14px;text-align:left;">NIS</th>
                    <th style="padding:10px 14px;text-align:left;">Nama Siswa</th>
                    <th style="padding:10px 14px;text-align:center;">L/P</th>
                    <th style="padding:10px 14px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas->siswas as $i => $siswa)
                <tr style="{{ $loop->even ? 'background:#f8f9fa;' : '' }}">
                    <td style="padding:9px 14px;">{{ $i+1 }}</td>
                    <td style="padding:9px 14px;">{{ $siswa->nis }}</td>
                    <td style="padding:9px 14px;font-weight:500;">{{ $siswa->nama }}</td>
                    <td style="padding:9px 14px;text-align:center;">{{ $siswa->jenis_kelamin }}</td>
                    <td style="padding:9px 14px;text-align:center;">
                        <a href="{{ route('guru.raport.cetak', $siswa->id) }}"
                           target="_blank"
                           style="background:#e74c3c;color:#fff;padding:5px 14px;border-radius:5px;font-size:12px;text-decoration:none;">
                            <i class="fas fa-print"></i> Cetak Raport
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:20px;text-align:center;color:#aaa;">Belum ada siswa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="card"><div class="card-body" style="text-align:center;color:#7f8c8d;">Anda tidak memiliki kelas yang ditangani.</div></div>
@endforelse

@endsection