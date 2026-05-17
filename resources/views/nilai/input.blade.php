@extends('layouts.app')
@section('title', 'Input Nilai - ' . $pembelajaran->mataPelajaran->nama)
@section('page-title', 'Input Nilai — ' . $pembelajaran->mataPelajaran->nama . ' (' . $pembelajaran->kelas->nama . ')')

@section('content')

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 text-green-800 border border-green-300 rounded-lg text-sm flex items-center gap-2">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Info Box -->
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4 text-sm">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div>
            <p class="text-blue-500 text-xs font-semibold uppercase">Mata Pelajaran</p>
            <p class="font-semibold text-gray-800">{{ $pembelajaran->mataPelajaran->nama }}</p>
        </div>
        <div>
            <p class="text-blue-500 text-xs font-semibold uppercase">Kelas</p>
            <p class="font-semibold text-gray-800">{{ $pembelajaran->kelas->nama }}</p>
        </div>
        <div>
            <p class="text-blue-500 text-xs font-semibold uppercase">Guru</p>
            <p class="font-semibold text-gray-800">{{ $pembelajaran->guru->nama }}</p>
        </div>
        <div>
            <p class="text-blue-500 text-xs font-semibold uppercase">KKM</p>
            <p class="font-bold text-orange-600 text-lg">{{ $pembelajaran->mataPelajaran->kkm }}</p>
        </div>
    </div>
</div>

<div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-xl text-xs text-yellow-800">
    <i class="fas fa-calculator mr-1"></i>
    <strong>Rumus Nilai Akhir:</strong> (Pengetahuan + Keterampilan + PTS + PAS) ÷ 4
</div>

<form method="POST" action="{{ route('nilai.simpan') }}">
    @csrf
    <input type="hidden" name="mata_pelajaran_id" value="{{ $pembelajaran->mata_pelajaran_id }}">

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="text-left px-3 py-3 w-8">No</th>
                        <th class="text-left px-3 py-3 w-24">NIS</th>
                        <th class="text-left px-3 py-3">Nama Siswa</th>
                        <th class="text-left px-3 py-3 w-4">L/P</th>
                        <th class="text-center px-3 py-3 w-20">Pengetahuan</th>
                        <th class="text-center px-3 py-3 w-20">Keterampilan</th>
                        <th class="text-center px-3 py-3 w-20">PTS</th>
                        <th class="text-center px-3 py-3 w-20">PAS</th>
                        <th class="text-center px-3 py-3 w-20">Rata-Rata</th>
                        <th class="text-left px-3 py-3">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $i => $siswa)
                    @php $n = $nilais[$siswa->id] ?? null; @endphp
                    <tr class="border-b border-gray-100 hover:bg-gray-50 {{ $loop->even ? 'bg-gray-50/50' : '' }}"
                        x-data="{
                            np:  {{ $n->nilai_pengetahuan  ?? 0 }},
                            nk:  {{ $n->nilai_keterampilan ?? 0 }},
                            pts: {{ $n->nilai_pts          ?? 0 }},
                            pas: {{ $n->nilai_pas          ?? 0 }},
                            get avg() { return ((+this.np + +this.nk + +this.pts + +this.pas) / 4).toFixed(2); }
                        }">
                        <td class="px-3 py-2 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-3 py-2 font-mono text-xs text-gray-600">{{ $siswa->nis }}</td>
                        <td class="px-3 py-2 font-medium">{{ $siswa->nama }}</td>
                        <td class="px-3 py-2 text-center text-xs text-gray-500">{{ $siswa->jenis_kelamin }}</td>
                        <td class="px-2 py-2">
                            <input type="number" min="0" max="100" step="0.5"
                                   name="nilai[{{ $siswa->id }}][pengetahuan]"
                                   x-model="np"
                                   class="w-full border border-gray-300 rounded px-2 py-1.5 text-center text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" min="0" max="100" step="0.5"
                                   name="nilai[{{ $siswa->id }}][keterampilan]"
                                   x-model="nk"
                                   class="w-full border border-gray-300 rounded px-2 py-1.5 text-center text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" min="0" max="100" step="0.5"
                                   name="nilai[{{ $siswa->id }}][pts]"
                                   x-model="pts"
                                   class="w-full border border-gray-300 rounded px-2 py-1.5 text-center text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" min="0" max="100" step="0.5"
                                   name="nilai[{{ $siswa->id }}][pas]"
                                   x-model="pas"
                                   class="w-full border border-gray-300 rounded px-2 py-1.5 text-center text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200">
                        </td>
                        <td class="px-3 py-2 text-center">
                            <span class="font-bold text-sm"
                                  :class="avg >= {{ $pembelajaran->mataPelajaran->kkm }} ? 'text-green-600' : 'text-red-500'"
                                  x-text="avg"></span>
                        </td>
                        <td class="px-2 py-2">
                            <input type="text"
                                   name="nilai[{{ $siswa->id }}][deskripsi]"
                                   value="{{ $n->deskripsi ?? '' }}"
                                   placeholder="Deskripsi singkat..."
                                   class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs focus:outline-none focus:border-blue-400 min-w-[200px]">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-10 text-center text-gray-400">
                            Tidak ada siswa aktif di kelas ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-gray-200 flex gap-3 items-center">
            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition">
                <i class="fas fa-save"></i> Simpan Semua Nilai
            </button>
            <a href="{{ route('nilai.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition">
                ← Kembali
            </a>
            <span class="text-xs text-gray-400 ml-auto">
                <i class="fas fa-info-circle"></i>
                Nilai yang sudah ada akan diperbarui, nilai baru akan ditambahkan.
            </span>
        </div>
    </div>
</form>

@endsection