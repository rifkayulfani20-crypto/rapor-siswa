{{-- ══════════════════════════════════════════════════════════
     resources/views/nilai/index.blade.php
══════════════════════════════════════════════════════════ --}}
@extends('layouts.app')
@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')

@section('content')

<div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-800 flex items-start gap-2">
    <i class="fas fa-info-circle mt-0.5"></i>
    <span>Pilih mata pelajaran untuk mulai input nilai siswa. Nilai akhir dihitung otomatis dari rata-rata 4 komponen.</span>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200">
        <h3 class="font-bold text-gray-800 text-sm">Daftar Pembelajaran</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="text-left px-4 py-3">No</th>
                    <th class="text-left px-4 py-3">Mata Pelajaran</th>
                    <th class="text-left px-4 py-3">Kelas</th>
                    <th class="text-left px-4 py-3">Guru Pengampu</th>
                    <th class="text-left px-4 py-3">KKM</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-left px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelajaran as $i => $p)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                    <td class="px-4 py-3 font-medium">{{ $p->mataPelajaran->nama }}</td>
                    <td class="px-4 py-3">{{ $p->kelas->nama }}</td>
                    <td class="px-4 py-3">{{ $p->guru->nama }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded text-xs font-bold">
                            {{ $p->mataPelajaran->kkm }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded text-xs font-bold
                            {{ $p->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('nilai.input', $p) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded text-xs flex items-center gap-1 w-fit transition">
                            <i class="fas fa-pen"></i> Input Nilai
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2 block"></i>
                        Belum ada data pembelajaran.
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('pembelajaran.create') }}" class="text-blue-500 underline">Tambah pembelajaran</a>
                        @else
                            Hubungi admin untuk ditambahkan.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection


{{-- ══════════════════════════════════════════════════════════
     resources/views/nilai/input.blade.php
     SIMPAN FILE INI DI: resources/views/nilai/input.blade.php
══════════════════════════════════════════════════════════ --}}