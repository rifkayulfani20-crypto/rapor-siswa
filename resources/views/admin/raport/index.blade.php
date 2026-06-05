    @extends('layouts.app')
    @section('title', 'Cetak Raport')
    @section('page-title', 'Cetak Raport')

    @section('content')
    <div class="page-title"><i class="fa fa-print"></i> Cetak Raport</div>

    {{-- Summary badge --}}
    <div class="mb-5">
        <span class="inline-flex items-center gap-2 bg-green-100 text-green-800 text-sm font-semibold px-4 py-2 rounded-full">
            <i class="fa fa-users"></i>
            Total: {{ $kelas->sum(fn($k) => $k->siswas->count()) }} Siswa
        </span>
    </div>

    {{-- Kelas List --}}
    @forelse($kelas as $k)
    <div class="bg-white rounded-xl shadow-sm mb-6 overflow-hidden">

        {{-- Header Kelas --}}
        <div class="flex items-center justify-between px-5 py-3 bg-[#2c3e50]">
            <span class="text-white font-semibold text-sm">
                <i class="fa fa-door-open mr-2"></i>{{ $k->nama }}
            </span>
            <span class="bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ $k->siswas->count() }} Siswa
            </span>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#2c3e50] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold w-12">No</th>
                        <th class="px-4 py-3 text-left font-semibold">NIS</th>
                        <th class="px-4 py-3 text-left font-semibold">Nama Siswa</th>
                        <th class="px-4 py-3 text-left font-semibold">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-center font-semibold">Status</th>
                        <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($k->siswas as $i => $siswa)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 font-mono text-gray-600">{{ $siswa->nis }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $siswa->nama }}</td>
                        <td class="px-4 py-3">
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="text-blue-500">
                                    <i class="fa fa-mars mr-1"></i> Laki-laki
                                </span>
                            @else
                                <span class="text-pink-500">
                                    <i class="fa fa-venus mr-1"></i> Perempuan
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($siswa->status == 'Aktif')
                                <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $siswa->status }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('raport.cetak', $siswa) }}" target="_blank"
                            class="inline-flex items-center gap-1 bg-[#3498db] hover:bg-[#2980b9] text-white text-xs font-semibold px-3 py-2 rounded-md transition">
                                <i class="fa fa-print"></i> Cetak
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">
                            <i class="fa fa-users-slash mr-2"></i> Tidak ada siswa di kelas ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm p-10 text-center text-gray-400">
        <i class="fa fa-folder-open fa-3x block mb-3"></i>
        Belum ada data kelas.
    </div>
    @endforelse

    @endsection