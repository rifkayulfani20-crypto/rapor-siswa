@extends('layouts.fullscreen-layout')

@section('content')
<div class="min-h-screen bg-gray-50 text-gray-900">

    {{-- NAVBAR --}}
    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-blue-500 text-base font-bold text-white">R</span>
                <span class="text-sm font-semibold text-gray-900 sm:text-base">Sistem Pengolahan Rapor Siswa</span>
            </a>
            <nav class="hidden items-center gap-8 text-sm font-medium text-gray-600 lg:flex">
                <a href="{{ route('home') }}" class="text-blue-600">Home</a>
                <a href="#documents" class="transition hover:text-blue-600">Dokumen</a>
                <a href="#announcements" class="transition hover:text-blue-600">Pengumuman</a>
                <a href="#categories" class="transition hover:text-blue-600">Akses</a>
            </nav>
            <a href="{{ route('login') }}" class="inline-flex rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:border-blue-500 hover:text-blue-600">
                Masuk
            </a>
        </div>
    </header>

    <main>
        {{-- HERO --}}
        <section class="relative bg-cover bg-center" style="background-image: linear-gradient(90deg, rgba(8,20,48,0.88), rgba(16,82,120,0.58)), url('https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=1600&q=80');">
            <div class="mx-auto flex min-h-[520px] max-w-7xl items-center px-4 py-16 sm:px-6 lg:px-8">
                <div class="max-w-3xl text-white">
                    <p class="text-sm font-semibold uppercase tracking-widest text-blue-200">Portal Rapor Sekolah</p>
                    <h1 class="mt-5 text-4xl font-bold leading-tight tracking-tight sm:text-5xl">
                        Pengolahan Rapor Siswa Terpusat
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-white/80 sm:text-lg">
                        Portal pengolahan nilai, rapor, dan monitoring akademik untuk admin, guru, wali kelas, dan siswa.
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition hover:bg-blue-50">
                            Masuk ke Sistem
                        </a>
                        <a href="#documents" class="inline-flex items-center justify-center rounded-lg border border-white/50 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            Lihat Dokumen
                        </a>
                    </div>
                    <div class="mt-10 grid max-w-xl grid-cols-2 gap-8 border-t border-white/25 pt-7">
                        @foreach(array_slice($stats, 0, 2) as $stat)
                        <div>
                            <p class="text-4xl font-bold tracking-tight sm:text-5xl">{{ number_format($stat['value']) }}</p>
                            <p class="mt-2 text-sm leading-6 text-white/75">{{ $stat['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- DOKUMEN --}}
        <section id="documents" class="relative z-10 mx-auto -mt-12 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 md:grid-cols-2">
                @foreach($documents as $document)
                <a href="{{ $document['route'] }}" class="group flex items-start gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-md transition hover:-translate-y-0.5 hover:border-blue-300">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-50">
                        <i class="fa fa-file-pdf text-red-500 text-xl"></i>
                    </span>
                    <span class="min-w-0">
                        <span class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ $document['type'] }}</span>
                        <span class="mt-1 block text-lg font-semibold text-gray-900 transition group-hover:text-blue-600">{{ $document['title'] }}</span>
                        <span class="mt-2 block text-sm leading-6 text-gray-500">{{ $document['description'] }}</span>
                    </span>
                </a>
                @endforeach
            </div>
        </section>

        {{-- PENGUMUMAN + SIDEBAR --}}
        <section id="announcements" class="mx-auto grid max-w-7xl gap-8 px-4 py-14 sm:px-6 lg:grid-cols-[minmax(0,1fr)_360px] lg:px-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-widest text-blue-600">Pengumuman rapor</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900">Informasi terbaru</h2>
                <div class="mt-7 space-y-5">
                    @foreach($announcements as $announcement)
                    <article class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-blue-50 text-sm font-bold text-blue-600">
                                {{ $announcement['initial'] }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-xl font-semibold leading-7 text-gray-900">{{ $announcement['title'] }}</h3>
                                <p class="mt-1 text-sm text-gray-500">by {{ $announcement['author'] }} - {{ $announcement['date'] }}</p>
                                <p class="mt-4 text-sm leading-7 text-gray-600">{{ $announcement['description'] }}</p>
                                <a href="{{ route('login') }}" class="mt-5 inline-flex text-sm font-semibold text-blue-600 transition hover:text-blue-700">
                                    Buka detail &rarr;
                                </a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>

            {{-- SIDEBAR --}}
            <aside class="space-y-6">
                {{-- Search --}}
                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <label class="text-sm font-semibold text-gray-900">Cari data rapor</label>
                    <div class="mt-3 flex rounded-lg border border-gray-300 bg-white">
                        <input type="search" placeholder="Cari siswa, kelas..." class="h-11 min-w-0 flex-1 rounded-l-lg border-0 bg-transparent px-4 text-sm text-gray-700 outline-none placeholder:text-gray-400">
                        <a href="{{ route('login') }}" class="inline-flex h-11 items-center rounded-r-lg bg-blue-500 px-4 text-sm font-semibold text-white transition hover:bg-blue-600">
                            Cari
                        </a>
                    </div>
                </div>

                {{-- Kategori Akses --}}
                <div id="categories" class="rounded-lg border border-gray-200 bg-white p-5">
                    <p class="text-sm font-semibold text-gray-900">Kategori akses</p>
                    <div class="mt-4 space-y-3">
                        @foreach($roleCards as $role)
                        <a href="{{ $role['login_route'] }}" class="flex items-center justify-between gap-3 rounded-lg border border-gray-200 px-4 py-3 text-sm transition hover:border-blue-300 hover:text-blue-600">
                            <span class="font-medium">{{ $role['label'] }}</span>
                            <span class="text-gray-400">{{ $role['item_count'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kelas Aktif --}}
                <div class="rounded-lg border border-gray-200 bg-white p-5">
                    <p class="text-sm font-semibold text-gray-900">Kelas aktif</p>
                    <div class="mt-4 space-y-3">
                        @forelse($classroomSummaries as $summary)
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="text-gray-600">{{ $summary['classroom'] }}</span>
                            <span class="font-semibold text-gray-900">{{ $summary['student_count'] }} siswa</span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-500">Belum ada data kelas.</p>
                        @endforelse
                    </div>
                </div>
            </aside>
        </section>

        {{-- STATISTIK --}}
        <section class="border-y border-gray-200 bg-white">
            <div class="mx-auto grid max-w-7xl gap-6 px-4 py-9 sm:px-6 md:grid-cols-4 lg:px-8">
                @foreach($stats as $stat)
                <div>
                    <p class="text-3xl font-bold tracking-tight text-gray-900">{{ number_format($stat['value']) }}</p>
                    <p class="mt-2 text-sm font-semibold text-gray-700">{{ $stat['label'] }}</p>
                    <p class="mt-1 text-sm leading-6 text-gray-500">{{ $stat['description'] }}</p>
                </div>
                @endforeach
            </div>
        </section>

        {{-- FOOTER --}}
        <footer class="bg-gray-950 text-white">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <p class="text-lg font-semibold">Sistem Pengolahan Rapor Siswa</p>
                    <p class="mt-3 max-w-xl text-sm leading-7 text-white/70">
                        Portal akademik untuk menyatukan input nilai, perhitungan rapor, dan monitoring sekolah.
                    </p>
                </div>
                <div>
                    <p class="text-sm font-semibold">Hubungi Kami</p>
                    <a href="{{ route('login') }}" class="mt-3 block text-sm text-white/70 transition hover:text-white">Admin Sekolah</a>
                </div>
                <div>
                    <p class="text-sm font-semibold">Navigasi</p>
                    <div class="mt-3 flex gap-4 text-sm text-white/70">
                        <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                        <a href="#announcements" class="transition hover:text-white">Pengumuman</a>
                        <a href="#categories" class="transition hover:text-white">Akses</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 py-4 text-center text-xs text-white/40">
               Copyright &copy; {{ date('Y') }} <a href="#">Sistem Pengolahan Rapor Siswa</a>
            </div>
        </footer>
    </main>
</div>
@endsection
