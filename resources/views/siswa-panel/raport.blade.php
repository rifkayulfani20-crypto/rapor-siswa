@extends('layouts.siswa')
@section('content')

<h1 class="page-title">Cetak Raport</h1>

<div style="margin-bottom:16px">
    <button onclick="window.print()" class="btn btn-primary" style="background:#3498db;color:white;padding:8px 20px;border:none;border-radius:5px;cursor:pointer;font-size:13px">
        <i class="fa fa-print"></i> Cetak / Download PDF
    </button>
</div>

<div id="raport" class="card" style="max-width:800px;margin:0 auto;padding:30px">

    {{-- Header --}}
    <div style="text-align:center;border-bottom:3px solid #2c3e50;padding-bottom:16px;margin-bottom:20px">
        <h2 style="font-size:16px;font-weight:700;color:#2c3e50;text-transform:uppercase">{{ $sekolah?->nama ?? 'MTs Rekayasa' }}</h2>
        <p style="font-size:12px;color:#7f8c8d">{{ $sekolah?->alamat ?? '' }}</p>
        <p style="font-size:12px;color:#7f8c8d">Telp: {{ $sekolah?->telepon ?? '-' }} | Email: {{ $sekolah?->email ?? '-' }}</p>
    </div>

    <h3 style="text-align:center;font-size:15px;margin-bottom:20px;color:#2c3e50">
        LAPORAN HASIL BELAJAR SISWA<br>
        <small style="font-size:12px;color:#7f8c8d">{{ $tapel?->nama ?? '-' }}</small>
    </h3>

    {{-- Info Siswa --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;font-size:13px;margin-bottom:20px">
        @php
        $info = [
            'Nama Siswa'  => $siswa->nama,
            'NIS / NISN'  => $siswa->nis . ' / ' . $siswa->nisn,
            'Kelas'       => $siswa->kelas?->nama ?? '-',
            'Semester'    => $tapel?->semester ?? '-',
        ];
        @endphp
        @foreach($info as $k => $v)
        <div style="display:flex;gap:8px">
            <span style="width:100px;color:#7f8c8d">{{ $k }}</span>
            <span>: {{ $v }}</span>
        </div>
        @endforeach
    </div>

    {{-- Tabel Nilai --}}
    <table style="width:100%;border-collapse:collapse;font-size:12px;margin-bottom:20px">
        <thead style="background:#2c3e50;color:white">
            <tr>
                <th style="padding:8px;border:1px solid #ddd">#</th>
                <th style="padding:8px;border:1px solid #ddd;text-align:left">Mata Pelajaran</th>
                <th style="padding:8px;border:1px solid #ddd">KKM</th>
                <th style="padding:8px;border:1px solid #ddd">Nilai Akhir</th>
                <th style="padding:8px;border:1px solid #ddd">Predikat</th>
                <th style="padding:8px;border:1px solid #ddd">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilais as $i => $n)
            <tr>
                <td style="padding:7px 8px;border:1px solid #ddd;text-align:center">{{ $i+1 }}</td>
                <td style="padding:7px 8px;border:1px solid #ddd">{{ $n->mataPelajaran?->nama }}</td>
                <td style="padding:7px 8px;border:1px solid #ddd;text-align:center">{{ $n->mataPelajaran?->kkm ?? 75 }}</td>
                <td style="padding:7px 8px;border:1px solid #ddd;text-align:center;font-weight:700">{{ $n->nilai_akhir ?? '-' }}</td>
                <td style="padding:7px 8px;border:1px solid #ddd;text-align:center">{{ $n->getPredikat() }}</td>
                <td style="padding:7px 8px;border:1px solid #ddd;text-align:center">
                    {{ ($n->nilai_akhir ?? 0) >= ($n->mataPelajaran?->kkm ?? 75) ? 'Tuntas' : 'Belum Tuntas' }}
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;padding:20px;color:#999">Belum ada nilai</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background:#f8f9fa;font-weight:700">
                <td colspan="3" style="padding:8px;border:1px solid #ddd;text-align:right">Rata-rata:</td>
                <td style="padding:8px;border:1px solid #ddd;text-align:center">{{ round($nilais->avg('nilai_akhir'),2) }}</td>
                <td colspan="2" style="border:1px solid #ddd"></td>
            </tr>
        </tfoot>
    </table>

    {{-- PERINGKAT --}}
    <div style="font-size:12px;color:#2c3e50;margin-bottom:12px">
        <strong>Peringkat:</strong> {{ $peringkat['peringkat'] }} dari {{ $peringkat['total_siswa'] }} siswa &nbsp;|&nbsp;
        <strong>Rata-rata:</strong> {{ $peringkat['rata_rata'] }}
    </div>

    {{-- Kehadiran --}}
    <div style="margin-bottom:24px;font-size:13px">
        <strong>Kehadiran:</strong>
        <div style="display:flex;gap:24px;margin-top:8px">
            <span>Sakit: <strong>{{ $kehadiran->sakit ?? 0 }}</strong> hari</span>
            <span>Izin: <strong>{{ $kehadiran->izin ?? 0 }}</strong> hari</span>
            <span>Tanpa Keterangan: <strong>{{ $kehadiran->tanpa_keterangan ?? 0 }}</strong> hari</span>
        </div>
    </div>

    {{-- Tanda Tangan --}}
    <div style="display:flex;justify-content:space-between;font-size:12px;margin-top:40px">
        <div style="text-align:center">
            <p>Orang Tua / Wali</p>
            <div style="margin-top:60px">(__________________)</div>
        </div>
        <div style="text-align:center">
            <p>{{ $tapel?->tempat_pembagian ?? '' }}, {{ $tapel?->tanggal_pembagian?->format('d F Y') ?? '' }}</p>
            <p>Wali Kelas</p>
            <div style="margin-top:60px">(__________________)</div>
        </div>
        <div style="text-align:center">
            <p>Kepala Sekolah</p>
            <div style="margin-top:60px">{{ $sekolah?->kepala_sekolah ?? '(__________________)'  }}</div>
        </div>
    </div>
</div>

@push('scripts')
<style>
@media print {
    .sidebar, .topbar, footer, button { display: none !important; }
    .main { margin-left: 0 !important; }
    .content { padding: 0 !important; }
    #raport { box-shadow: none !important; border: none !important; }
}
</style>
@endpush
@endsection