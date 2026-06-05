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

        /* HEADER */
        .header { display:flex; align-items:center; justify-content:center; gap:16px; border-bottom: 3px double #1a1a1a; padding-bottom: 12px; margin-bottom: 14px; text-align:center; }
        .header .logo { font-size: 52px; line-height:1; }
        .header-text h1 { font-size:20px; font-weight:900; text-transform:uppercase; letter-spacing:2px; color:#1a1a1a; }
        .header-text h2 { font-size:15px; font-weight:700; text-transform:uppercase; margin-top:2px; }
        .header-text p  { font-size:12px; margin-top:2px; color:#444; }

        /* INFO SISWA */
        .info-section { border: 1px solid #1a1a1a; margin-bottom:14px; }
        .info-section table { width:100%; border-collapse:collapse; font-size:12px; }
        .info-section table td { padding:6px 12px; border:1px solid #ccc; }
        .info-section table td:first-child { width:160px; color:#444; background:#f9f9f9; font-weight:500; }

        /* SECTION TITLE */
        .section-title { font-weight:bold; font-size:12px; background:#1a3a5c; color:#fff; padding:6px 10px; margin:12px 0 0; }

        /* TABEL NILAI */
        table.nilai { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:0; }
        table.nilai th { background:#1a3a5c; color:#fff; padding:7px 8px; border:1px solid #aaa; text-align:center; }
        table.nilai td { padding:6px 8px; border:1px solid #ccc; vertical-align:middle; }
        table.nilai tr:nth-child(even) td { background:#f5f7fa; }

        /* PREDIKAT BADGE */
        .badge { display:inline-block; padding:2px 10px; border-radius:10px; font-size:11px; font-weight:bold; }
        .badge-A { background:#d5f5e3; color:#1e8449; }
        .badge-B { background:#d6eaf8; color:#1a5276; }
        .badge-C { background:#fef9e7; color:#9a7d0a; }
        .badge-D { background:#fdecea; color:#a93226; }

        /* REKAP BOX */
        .summary-box { display:grid; grid-template-columns:1fr 1fr 1fr; border:1px solid #1a3a5c; margin-bottom:14px; }
        .summary-box .item { padding:8px; text-align:center; border-right:1px solid #1a3a5c; }
        .summary-box .item:last-child { border-right:none; }
        .summary-box .item .label { font-size:11px; color:#555; font-weight:bold; text-transform:uppercase; }
        .summary-box .item .value { font-size:20px; font-weight:900; color:#1a3a5c; margin-top:2px; }
        .summary-header { background:#1a3a5c; color:#fff; text-align:center; font-size:11px; font-weight:bold; padding:4px; }

        /* SIKAP & KEHADIRAN */
        .bottom-section { display:grid; grid-template-columns:1fr 1fr 1fr; gap:0; border:1px solid #ccc; margin-bottom:14px; }
        .bottom-col { border-right:1px solid #ccc; }
        .bottom-col:last-child { border-right:none; }
        .bottom-col-title { background:#1a3a5c; color:#fff; font-weight:bold; font-size:11px; text-align:center; padding:5px; }
        table.sikap { width:100%; border-collapse:collapse; font-size:11px; }
        table.sikap th { background:#2c4f7c; color:#fff; padding:4px 8px; text-align:left; border-bottom:1px solid #ccc; }
        table.sikap td { padding:5px 8px; border-bottom:1px solid #eee; }
        .kehadiran-list { padding:8px 12px; font-size:12px; }
        .kehadiran-list .row { display:flex; justify-content:space-between; padding:4px 0; border-bottom:1px solid #eee; }
        .kehadiran-list .row:last-child { border-bottom:none; }
        .kehadiran-list .angka { font-weight:bold; }

        /* TTD */
        .ttd-section { margin-top:10px; }
        .ttd-kota { text-align:right; margin-bottom:16px; font-size:12px; }
        .ttd-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; text-align:center; font-size:12px; }
        .ttd-space { height:60px; }
        .ttd-line { border-top:1px solid #1a1a1a; padding-top:4px; font-weight:bold; }
        .ttd-nip { font-size:11px; font-weight:normal; margin-top:2px; color:#444; }

        @media print {
            .no-print { display:none !important; }
            body { font-size: 11px; }
            .wrapper { border:2px solid #000; max-width:100%; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button class="btn-print" onclick="window.print()">🖨 Cetak Raport</button>
    <a class="btn-back" href="{{ route('guru.raport') }}">← Kembali</a>
</div>

<div class="wrapper">

    {{-- HEADER --}}
    <div class="header">
        <div class="logo">🏫</div>
        <div class="header-text">
            <h1>SISTEM PENGOLAHAN RAPOR SISWA</h1>
            <h1>PESERTA DIDIK</h1>
        </div>
    </div>

    {{-- INFO SISWA --}}
    <div class="info-section">
        <table>
            <tr>
                <td>Nama Peserta Didik</td>
                <td><strong>{{ $siswa->nama }}</strong></td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>{{ $siswa->nis }} / {{ $siswa->nisn ?? '-' }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>{{ $siswa->kelas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>{{ $tapel->semester }}</td>
            </tr>
            <tr>
                <td>Wali Kelas</td>
                <td>{{ $siswa->kelas->waliKelas->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td>
                <td>{{ $tapel->nama ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- NILAI MATA PELAJARAN --}}
    <div class="section-title">A. Nilai Mata Pelajaran</div>
    <table class="nilai">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th style="width:220px;">Mata Pelajaran</th>
                <th style="width:60px;">KKM</th>
                <th style="width:80px;">Nilai Akhir</th>
                <th style="width:80px;">Predikat</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @php $totalNilai = 0; $countNilai = 0; @endphp
            @forelse($nilais as $i => $nilai)
            @php
                $na       = $nilai->nilai_akhir ?? 0;
                $kkm      = $nilai->mataPelajaran->kkm ?? 75;
                $predikat = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));
                $lulus    = $na >= $kkm;
                $totalNilai += $na;
                $countNilai++;
            @endphp
            <tr>
                <td style="text-align:center;">{{ $i+1 }}</td>
                <td>{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                <td style="text-align:center;">{{ $kkm }}</td>
                <td style="text-align:center;font-weight:bold;color:{{ $lulus ? '#1e8449' : '#c0392b' }};">
                    {{ number_format($na, 2) }}
                </td>
                <td style="text-align:center;">
                    <span class="badge badge-{{ $predikat }}">{{ $predikat }}</span>
                </td>
                <td>{{ $nilai->deskripsi ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#aaa;padding:14px;">Belum ada nilai</td></tr>
            @endforelse
        </tbody>
    </table>

    {{-- REKAP NILAI --}}
    @if($countNilai > 0)
    <div style="border:1px solid #1a3a5c;margin-bottom:14px;">
        <div class="summary-header">Rekap Nilai</div>
        <div class="summary-box" style="border:none;">
            <div class="item">
                <div class="label">Rata-rata Nilai Akhir</div>
                <div class="value">{{ number_format($rataRata, 1) }}</div>
            </div>
            <div class="item">
                <div class="label">Predikat</div>
                <div class="value">
                    @php $pred = $rataRata >= 90 ? 'A' : ($rataRata >= 80 ? 'B' : ($rataRata >= 70 ? 'C' : 'D')); @endphp
                    <span class="badge badge-{{ $pred }}" style="font-size:18px;">{{ $pred }}</span>
                </div>
            </div>
            <div class="item">
                <div class="label">Peringkat Kelas</div>
                <div class="value" style="color:#c0392b;">{{ $peringkat }} dari {{ $totalSiswa }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- SIKAP & KEHADIRAN --}}
    <div class="bottom-section">
        <div class="bottom-col">
            <div class="bottom-col-title">B. Sikap Sosial</div>
            <table class="sikap">
                <thead><tr><th>Aspek</th><th>Predikat</th></tr></thead>
                <tbody>
                    <tr>
                        <td>Sikap Sosial</td>
                        <td>{{ $sikap->predikat_sosial ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:11px;color:#555;font-style:italic;">
                            {{ $sikap->deskripsi_sosial ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bottom-col">
            <div class="bottom-col-title">C. Sikap Spiritual</div>
            <table class="sikap">
                <thead><tr><th>Aspek</th><th>Predikat</th></tr></thead>
                <tbody>
                    <tr>
                        <td>Sikap Spiritual</td>
                        <td>{{ $sikap->predikat_spiritual ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-size:11px;color:#555;font-style:italic;">
                            {{ $sikap->deskripsi_spiritual ?? '-' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bottom-col">
            <div class="bottom-col-title">D. Kehadiran</div>
            <div class="kehadiran-list">
                <div class="row">
                    <span>Sakit</span>
                    <span>: <span class="angka" style="color:#e74c3c;">{{ $kehadiran->sakit ?? 0 }}</span> hari</span>
                </div>
                <div class="row">
                    <span>Izin</span>
                    <span>: <span class="angka" style="color:#e67e22;">{{ $kehadiran->izin ?? 0 }}</span> hari</span>
                </div>
                <div class="row">
                    <span>Tanpa Keterangan</span>
                    <span>: <span class="angka" style="color:#8e44ad;">{{ $kehadiran->tanpa_keterangan ?? 0 }}</span> hari</span>
                </div>
                <div class="row" style="margin-top:4px;font-weight:bold;">
                    <span>Total Tidak Hadir</span>
                    <span>: <span class="angka" style="color:#2c3e50;">
                        {{ ($kehadiran->sakit ?? 0) + ($kehadiran->izin ?? 0) + ($kehadiran->tanpa_keterangan ?? 0) }}
                    </span> hari</span>
                </div>
            </div>
        </div>
    </div>

    {{-- TTD --}}
    <div class="ttd-section">
        <div class="ttd-kota">
            {{ $tapel->tempat_pembagian ?? 'Batam' }}, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
        <div class="ttd-grid">
            <div>
                <p>Orang Tua / Wali Murid,</p>
                <div class="ttd-space"></div>
                <div class="ttd-line">( _________________________ )</div>
            </div>
            <div>
                <p>Wali Kelas,</p>
                <div class="ttd-space"></div>
                <div class="ttd-line">{{ $siswa->kelas->waliKelas->nama ?? '___________________________' }}</div>
                <div class="ttd-nip">NIP. {{ $siswa->kelas->waliKelas->nip ?? '-' }}</div>
            </div>
            <div>
                <p>Kepala Sekolah,</p>
                <div class="ttd-space"></div>
                <div class="ttd-line">{{ \App\Models\Sekolah::first()?->kepala_sekolah ?? '___________________________' }}</div>
                <div class="ttd-nip">NIP. {{ \App\Models\Sekolah::first()?->nip_kepala_sekolah ?? '-' }}</div>
            </div>
        </div>
    </div>

</div>
</body>
</html>