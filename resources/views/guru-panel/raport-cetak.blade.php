<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport - {{ $siswa->nama }}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; color: #1a1a1a; background: #fff; }
        .no-print { margin-bottom: 16px; padding: 12px; background: #f8f9fa; border-bottom: 1px solid #ddd; }
        .no-print button, .no-print a {
            display:inline-block; padding:8px 18px; border-radius:5px;
            text-decoration:none; font-size:13px; cursor:pointer; border:none;
        }
        .btn-print { background:#c0392b; color:#fff; }
        .btn-back  { background:#ddd; color:#333; }
        .wrapper   { max-width: 820px; margin: 0 auto; border: 2px solid #1a1a1a; padding: 20px 24px; }
        .header    { text-align:center; border-bottom: 2px solid #1a1a1a; padding-bottom: 12px; margin-bottom: 14px; }
        .header h1 { font-size:15px; text-transform:uppercase; letter-spacing:1px; }
        .header p  { font-size:12px; margin-top:3px; }
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:16px; font-size:12px; }
        .info-grid td:first-child { width:110px; color:#444; }
        table.nilai { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:16px; }
        table.nilai th { background:#2c3e50; color:#fff; padding:7px 10px; }
        table.nilai td { padding:6px 10px; border:1px solid #ccc; }
        table.nilai tr:nth-child(even) td { background:#f5f5f5; }
        .section-title { font-weight:bold; font-size:12px; background:#ecf0f1; padding:5px 10px; margin:12px 0 6px; border-left:4px solid #2c3e50; }
        table.sikap { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:12px; }
        table.sikap th { background:#34495e; color:#fff; padding:6px 10px; text-align:left; }
        table.sikap td { padding:6px 10px; border:1px solid #ccc; }
        .kehadiran-box { display:flex; gap:20px; margin-bottom:14px; }
        .kehadiran-item { border:1px solid #ccc; border-radius:6px; padding:8px 16px; text-align:center; flex:1; }
        .kehadiran-item .angka { font-size:22px; font-weight:bold; color:#e74c3c; }
        .kehadiran-item .label { font-size:11px; color:#666; }
        .peringkat-box { background:#fef9e7; border:1px solid #f0c040; border-radius:6px; padding:10px 16px; margin-bottom:14px; font-size:12px; }
        .ttd-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; margin-top:20px; text-align:center; font-size:12px; }
        .ttd-space { height:55px; }
        .ttd-line { border-top:1px solid #1a1a1a; padding-top:4px; font-weight:bold; }
        .badge { display:inline-block; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:bold; }
        .badge-A { background:#d5f5e3; color:#1e8449; }
        .badge-B { background:#d6eaf8; color:#1a5276; }
        .badge-C { background:#fef9e7; color:#9a7d0a; }
        .badge-D { background:#fdecea; color:#a93226; }
        .rata-row td { font-weight:bold; background:#eaf2ff !important; }
        @media print {
            .no-print { display:none !important; }
            body { font-size: 11px; }
            .wrapper { border:2px solid #000; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()"><i>🖨</i> Cetak Raport</button>
    <a class="btn-back" href="{{ route('guru.raport') }}">← Kembali</a>
</div>

<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        <h1>Laporan Hasil Belajar Siswa</h1>
        <p>{{ $tapel->tahun_pelajaran ?? '-' }} &nbsp;|&nbsp; Semester {{ $tapel->semester == 1 ? '1 / Ganjil' : '2 / Genap' }}</p>
    </div>

    {{-- INFO SISWA --}}
    <div class="info-grid">
        <table>
            <tr><td>Nama Siswa</td><td>: <strong>{{ $siswa->nama }}</strong></td></tr>
            <tr><td>NIS / NISN</td><td>: {{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</td></tr>
            <tr><td>Kelas</td><td>: {{ $siswa->kelas->nama ?? '-' }}</td></tr>
        </table>
        <table>
            <tr><td>Semester</td><td>: {{ $tapel->semester == 1 ? 'Ganjil' : 'Genap' }}</td></tr>
            <tr><td>Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
            <tr><td>Wali Kelas</td><td>: {{ $siswa->kelas->waliKelas->nama ?? '-' }}</td></tr>
        </table>
    </div>

    {{-- NILAI MATA PELAJARAN --}}
    <div class="section-title">A. Nilai Mata Pelajaran</div>
    <table class="nilai">
        <thead>
            <tr>
                <th style="width:35px;">#</th>
                <th>Mata Pelajaran</th>
                <th style="width:50px;text-align:center;">KKM</th>
                <th style="width:65px;text-align:center;">Pengetahuan</th>
                <th style="width:55px;text-align:center;">PTS</th>
                <th style="width:55px;text-align:center;">PAS</th>
                <th style="width:70px;text-align:center;">Nilai Akhir</th>
                <th style="width:60px;text-align:center;">Predikat</th>
                <th style="width:65px;text-align:center;">Ket.</th>
            </tr>
        </thead>
        <tbody>
            @php $totalNilai = 0; $countNilai = 0; @endphp
            @forelse($nilais as $i => $nilai)
            @php
                $na = $nilai->nilai_akhir ?? 0;
                $kkm = $nilai->mataPelajaran->kkm ?? 75;
                $predikat = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));
                $lulus = $na >= $kkm;
                $totalNilai += $na;
                $countNilai++;
            @endphp
            <tr>
                <td style="text-align:center;">{{ $i+1 }}</td>
                <td>{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                <td style="text-align:center;">{{ $kkm }}</td>
                <td style="text-align:center;">{{ $nilai->nilai_pengetahuan ?? '-' }}</td>
                <td style="text-align:center;">{{ $nilai->nilai_pts ?? '-' }}</td>
                <td style="text-align:center;">{{ $nilai->nilai_pas ?? '-' }}</td>
                <td style="text-align:center;font-weight:bold;color:{{ $lulus ? '#1e8449' : '#c0392b' }};">
                    {{ number_format($na, 2) }}
                </td>
                <td style="text-align:center;">
                    <span class="badge badge-{{ $predikat }}">{{ $predikat }}</span>
                </td>
                <td style="text-align:center;color:{{ $lulus ? '#1e8449' : '#c0392b' }};">
                    {{ $lulus ? 'Tuntas' : 'Belum' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="text-align:center;color:#aaa;padding:14px;">Belum ada nilai</td></tr>
            @endforelse
            @if($countNilai > 0)
            <tr class="rata-row">
                <td colspan="6" style="text-align:right;padding:7px 10px;">Rata-rata Keseluruhan:</td>
                <td style="text-align:center;">{{ number_format($rataRata, 2) }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>

    {{-- PERINGKAT --}}
    <div class="peringkat-box">
        <strong>📊 Peringkat:</strong>
        &nbsp; <strong style="font-size:15px;color:#c0392b;">{{ $peringkat }}</strong>
        dari <strong>{{ $totalSiswa }}</strong> siswa di kelas
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <strong>Rata-rata Nilai:</strong> {{ number_format($rataRata, 2) }}
    </div>

    {{-- SIKAP SPIRITUAL --}}
    <div class="section-title">B. Sikap Spiritual</div>
    <table class="sikap">
        <thead><tr><th style="width:120px;">Predikat</th><th>Deskripsi</th></tr></thead>
        <tbody>
            <tr>
                <td>
                    @if($sikap && $sikap->predikat_spiritual)
                        <span class="badge badge-{{ $sikap->predikat_spiritual }}">{{ $sikap->predikat_spiritual }}</span>
                    @else
                        <span style="color:#aaa;">-</span>
                    @endif
                </td>
                <td>{{ $sikap->deskripsi_spiritual ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    {{-- SIKAP SOSIAL --}}
    <div class="section-title">C. Sikap Sosial</div>
    <table class="sikap">
        <thead><tr><th style="width:120px;">Predikat</th><th>Deskripsi</th></tr></thead>
        <tbody>
            <tr>
                <td>
                    @if($sikap && $sikap->predikat_sosial)
                        <span class="badge badge-{{ $sikap->predikat_sosial }}">{{ $sikap->predikat_sosial }}</span>
                    @else
                        <span style="color:#aaa;">-</span>
                    @endif
                </td>
                <td>{{ $sikap->deskripsi_sosial ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    {{-- KEHADIRAN --}}
    <div class="section-title">D. Kehadiran</div>
    <div class="kehadiran-box">
        <div class="kehadiran-item">
            <div class="angka" style="color:#e74c3c;">{{ $kehadiran->sakit ?? 0 }}</div>
            <div class="label">Sakit (hari)</div>
        </div>
        <div class="kehadiran-item">
            <div class="angka" style="color:#e67e22;">{{ $kehadiran->izin ?? 0 }}</div>
            <div class="label">Izin (hari)</div>
        </div>
        <div class="kehadiran-item">
            <div class="angka" style="color:#8e44ad;">{{ $kehadiran->tanpa_keterangan ?? 0 }}</div>
            <div class="label">Tanpa Keterangan (hari)</div>
        </div>
        <div class="kehadiran-item">
            <div class="angka" style="color:#2c3e50;">
                {{ ($kehadiran->sakit ?? 0) + ($kehadiran->izin ?? 0) + ($kehadiran->tanpa_keterangan ?? 0) }}
            </div>
            <div class="label">Total Tidak Hadir</div>
        </div>
    </div>

    {{-- TTD --}}
    <div class="ttd-grid">
        <div>
            <p>Orang Tua / Wali</p>
            <div class="ttd-space"></div>
            <div class="ttd-line">(______________)</div>
        </div>
        <div>
            <p>{{ $tapel->kota ?? 'Ciamis' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Wali Kelas</p>
            <div class="ttd-space"></div>
            <div class="ttd-line">{{ $siswa->kelas->waliKelas->nama ?? '_______________' }}</div>
        </div>
        <div>
            <p>Kepala Sekolah</p>
            <div class="ttd-space"></div>
            <div class="ttd-line">{{ \App\Models\Sekolah::first()?->kepala_sekolah ?? 'Kepala Sekolah' }}</div>
        </div>
    </div>

</div>

</body>
</html>