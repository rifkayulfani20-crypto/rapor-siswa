@extends('layouts.app')
@section('title', 'Cetak Raport')
@section('page-title', 'Cetak Raport')

@section('content')
<div class="space-y-4">
    @forelse($kelas as $k)
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <!-- Kelas Header -->
        <div class="px-5 py-3 bg-teal-600 text-white flex items-center justify-between">
            <span class="font-semibold flex items-center gap-2">
                <i class="fas fa-door-open"></i> {{ $k->nama }}
            </span>
            <span class="text-sm text-teal-100">{{ $k->siswas->count() }} Siswa</span>
        </div>

        <!-- Siswa List -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 text-xs">
                        <th class="text-left px-4 py-3">No</th>
                        <th class="text-left px-4 py-3">NIS</th>
                        <th class="text-left px-4 py-3">Nama Siswa</th>
                        <th class="text-left px-4 py-3">Jenis Kelamin</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($k->siswas as $i => $siswa)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $i + 1 }}</td>
                        <td class="px-4 py-2 font-mono text-xs">{{ $siswa->nis }}</td>
                        <td class="px-4 py-2 font-medium">{{ $siswa->nama }}</td>
                        <td class="px-4 py-2">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-0.5 rounded text-xs font-bold
                                {{ $siswa->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $siswa->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('raport.cetak', $siswa) }}"
                               target="_blank"
                               class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded text-xs flex items-center gap-1 w-fit transition">
                                <i class="fas fa-print"></i> Cetak Raport
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-400 text-xs">
                            Tidak ada siswa di kelas ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @empty
    <div class="text-center text-gray-400 py-10">Belum ada data kelas.</div>
    @endforelse
</div>
@endsection
```