<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport - {{ $siswa->nama }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
        }
    </style>
</head>
<body class="bg-white p-8 text-gray-800">

<div class="no-print mb-4 flex gap-3">
    <button onclick="window.print()"
            class="bg-red-500 text-white px-5 py-2 rounded-lg text-sm flex items-center gap-2 hover:bg-red-600">
        <i class="fas fa-print"></i> Cetak Raport
    </button>
    <a href="{{ route('raport.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm hover:bg-gray-300">
        &larr; Kembali
    </a>
</div>

<div class="border-2 border-gray-800 p-6 max-w-4xl mx-auto">
    <div class="text-center border-b-2 border-gray-800 pb-4 mb-4">
        <h1 class="text-xl font-bold uppercase">SISTEM PENGOLAHAN RAPOR SISWA</h1>
        <h2 class="text-lg font-bold">peserta didik</h2>
        <p class="text-sm">Tahun Pelajaran: {{ $tapel?->nama }} Semester {{ $tapel?->semester }}</p>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
        <div>
            <table>
                <tr><td class="pr-4 py-0.5">Nama</td><td>: <strong>{{ $siswa->nama }}</strong></td></tr>
                <tr><td class="pr-4 py-0.5">NIS</td><td>: {{ $siswa->nis }}</td></tr>
                <tr><td class="pr-4 py-0.5">NISN</td><td>: {{ $siswa->nisn ?? '-' }}</td></tr>
            </table>
        </div>
        <div>
            <table>
                <tr><td class="pr-4 py-0.5">Kelas</td><td>: {{ $siswa->kelas?->nama ?? '-' }}</td></tr>
                <tr><td class="pr-4 py-0.5">Jenis Kelamin</td><td>: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
            </table>
        </div>
    </div>

    <table class="w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-800 text-white">
                <th class="border border-gray-600 px-3 py-2 text-left">No</th>
                <th class="border border-gray-600 px-3 py-2 text-left">Mata Pelajaran</th>
                <th class="border border-gray-600 px-3 py-2 text-center">KKM</th>
                <th class="border border-gray-600 px-3 py-2 text-center">Pengetahuan</th>
                <th class="border border-gray-600 px-3 py-2 text-center">PTS</th>
                <th class="border border-gray-600 px-3 py-2 text-center">PAS</th>
                <th class="border border-gray-600 px-3 py-2 text-center">Nilai Akhir</th>
                <th class="border border-gray-600 px-3 py-2 text-center">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nilais as $i => $nilai)
            @php
                $na = $nilai->nilai_akhir;
                $kkm = $nilai->mataPelajaran->kkm;
                $predikat = $na >= 90 ? 'A' : ($na >= 80 ? 'B' : ($na >= 70 ? 'C' : 'D'));
                $lulus = $na >= $kkm;
            @endphp
            <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                <td class="border border-gray-300 px-3 py-1.5">{{ $i+1 }}</td>
                <td class="border border-gray-300 px-3 py-1.5">{{ $nilai->mataPelajaran->nama }}</td>
                <td class="border border-gray-300 px-3 py-1.5 text-center">{{ $kkm }}</td>
                <td class="border border-gray-300 px-3 py-1.5 text-center">{{ $nilai->nilai_pengetahuan ?? '-' }}</td>
                <td class="border border-gray-300 px-3 py-1.5 text-center">{{ $nilai->nilai_pts ?? '-' }}</td>
                <td class="border border-gray-300 px-3 py-1.5 text-center">{{ $nilai->nilai_pas ?? '-' }}</td>
                <td class="border border-gray-300 px-3 py-1.5 text-center font-semibold
                        {{ $lulus ? 'text-green-700' : 'text-red-600' }}">
                    {{ number_format($na, 1) }}
                </td>
                <td class="border border-gray-300 px-3 py-1.5 text-center font-bold">{{ $predikat }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="border border-gray-300 px-3 py-4 text-center text-gray-400">Belum ada nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="grid grid-cols-2 gap-8 mt-10 text-sm">
        <div class="text-center">
            <p>Mengetahui,</p>
            <p>Kepala Sekolah</p>
            <div class="h-16"></div>
            <p class="font-semibold border-t border-gray-800 pt-1">Elfin Pratama, S.T</p>
            <p class="text-xs text-gray-500">NIP. -</p>
        </div>
        <div class="text-center">
            <p>Wali Kelas,</p>
            <p>&nbsp;</p>
            <div class="h-16"></div>
            <p class="font-semibold border-t border-gray-800 pt-1">{{ $siswa->kelas?->waliKelas?->nama ?? '_______________' }}</p>
            <p class="text-xs text-gray-500">NIP. -</p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>