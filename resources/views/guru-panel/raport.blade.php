@extends('layouts.guru')
@section('title', 'Cetak Raport')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
        <i class="fas fa-print text-[#1a3a6c]"></i> Cetak Raport
    </h1>
    <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 text-sm font-semibold px-4 py-2 rounded-full border border-blue-200">
        <i class="fas fa-users"></i>
        Total: {{ $kelass->sum(fn($k) => $k->siswas->count()) }} Siswa
    </span>
</div>

@forelse($kelass as $kelas)
<div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden border border-gray-100">

    {{-- Header Kelas --}}
    <div class="flex items-center justify-between px-5 py-3 bg-[#1a3a6c]">
        <span class="text-white font-semibold text-sm flex items-center gap-2">
            <i class="fas fa-door-open"></i>
            {{ $kelas->nama }}
            <span class="text-blue-200 font-normal text-xs">
                — {{ $kelas->tahunPelajaran->tahun_pelajaran ?? '-' }}
                &nbsp;·&nbsp;
               Sem. {{ $kelas->tahunPelajaran->semester ?? '-' }}
            </span>
        </span>
        <span class="bg-white/20 text-white text-xs font-semibold px-3 py-1 rounded-full">
            {{ $kelas->siswas->count() }} Siswa
        </span>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($kelas->siswas as $i => $siswa)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-4 py-3 text-gray-400 text-sm">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-mono text-gray-500 text-sm">{{ $siswa->nis }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $siswa->nama }}</td>
                    <td class="px-4 py-3">
                        @if($siswa->jenis_kelamin == 'L')
                            <span class="inline-flex items-center gap-1 text-blue-500 text-sm">
                                <i class="fas fa-mars"></i> Laki-laki
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-pink-500 text-sm">
                                <i class="fas fa-venus"></i> Perempuan
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if(($siswa->status ?? 'Aktif') == 'Aktif')
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Aktif</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $siswa->status }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('guru.raport.cetak', $siswa->id) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 bg-[#1a3a6c] hover:bg-[#122a52] text-white text-xs font-semibold px-3 py-2 rounded-lg transition-colors">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-10">
                        <i class="fas fa-users-slash text-2xl block mb-2"></i>
                        Tidak ada siswa di kelas ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@empty
<div class="bg-white rounded-xl shadow-sm p-12 text-center text-gray-400 border border-gray-100">
    <i class="fas fa-folder-open text-4xl block mb-3 text-gray-300"></i>
    <p class="text-sm">Anda tidak memiliki kelas yang ditangani.</p>
</div>
@endforelse

@endsection