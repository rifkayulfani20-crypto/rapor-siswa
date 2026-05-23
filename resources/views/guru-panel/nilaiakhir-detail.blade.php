@extends('layouts.guru')
@section('title', 'Nilai Akhir - ' . $kelas->nama)
@section('content')

<div class="page-title">Nilai Akhir - Kelas {{ $kelas->nama }}</div>

{{-- Info Kelas --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:16px 20px;border-left:4px solid #3498db;">
        <table style="font-size:13px;border-collapse:collapse;">
            <tr>
                <td style="padding:3px 0;color:#555;width:150px;">Wali Kelas</td>
                <td style="padding:3px 0;">: <strong>{{ optional($kelas->waliKelas)->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Tahun Pelajaran</td>
                <td style="padding:3px 0;">: <strong>{{ optional($kelas->tahunPelajaran)->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Semester</td>
                <td style="padding:3px 0;">: <strong>{{ optional($kelas->tahunPelajaran)->semester ?? '-' }}</strong></td>
            </tr>
        </table>
        <div style="margin-top:12px;">
            <a href="{{ route('guru.nilaiakhir') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

{{-- Tabel Nilai --}}
<div class="card">
    <div class="card-body" style="overflow-x:auto;">
        <table style="font-size:12px;border-collapse:collapse;width:100%;min-width:900px;">
            <thead>
                <tr style="background:#f39c12;color:#fff;text-align:center;">
                    <th colspan="4" style="padding:8px;border:1px solid #ddd;background:#2c3e50;"></th>
                    <th colspan="{{ $pembelajarans->count() + 1 }}" style="padding:8px;border:1px solid #ddd;">NILAI</th>
                </tr>
                <tr style="background:#2c3e50;color:#fff;text-align:center;">
                    <th style="padding:8px;border:1px solid #ddd;">#</th>
                    <th style="padding:8px;border:1px solid #ddd;">NIS</th>
                    <th style="padding:8px;border:1px solid #ddd;">Nama</th>
                    <th style="padding:8px;border:1px solid #ddd;">L/P</th>
                    @foreach($pembelajarans as $p)
                    <th style="padding:8px;border:1px solid #ddd;max-width:60px;word-wrap:break-word;">
                        {{ $p->mataPelajaran->singkatan ?? \Illuminate\Support\Str::limit($p->mataPelajaran->nama, 6) }}
                    </th>
                    @endforeach
                    <th style="padding:8px;border:1px solid #ddd;background:#f39c12;color:#fff;">Rata-Rata</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $i => $siswa)
                @php
                    $nilaiSiswa = $nilais[$siswa->id] ?? collect();
                    $total = 0;
                    $count = 0;
                @endphp
                <tr style="text-align:center;">
                    <td style="padding:6px 8px;border:1px solid #ddd;">{{ $i + 1 }}</td>
                    <td style="padding:6px 8px;border:1px solid #ddd;">{{ $siswa->nis }}</td>
                    <td style="padding:6px 8px;border:1px solid #ddd;text-align:left;">{{ strtoupper($siswa->nama) }}</td>
                    <td style="padding:6px 8px;border:1px solid #ddd;">{{ $siswa->jenis_kelamin }}</td>
                    @foreach($pembelajarans as $p)
                    @php
                        $nilai = $nilaiSiswa->firstWhere('mata_pelajaran_id', $p->mata_pelajaran_id);
                        $na = $nilai->nilai_akhir ?? '-';
                        if ($na !== '-') { $total += $na; $count++; }
                    @endphp
                    <td style="padding:6px 8px;border:1px solid #ddd;">{{ $na }}</td>
                    @endforeach
                    <td style="padding:6px 8px;border:1px solid #ddd;background:#fef9e7;font-weight:bold;">
                        {{ $count > 0 ? number_format($total / $count, 2) : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $pembelajarans->count() + 5 }}" style="text-align:center;padding:30px;color:#7f8c8d;">
                        Tidak ada data siswa
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection