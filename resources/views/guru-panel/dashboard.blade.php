@extends('layouts.guru')
@section('title', 'Dashboard Guru')
@section('content')

<div class="page-title">Dashboard</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-2 gap-4 mb-6">

    {{-- Profil Guru --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold leading-snug">{{ auth()->user()->name }}</div>
            <div class="text-sm opacity-85 mt-1">Guru</div>
            <a href="{{ route('guru.profil') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat profil ›</a>
        </div>
        <i class="fas fa-chalkboard-teacher text-5xl opacity-25"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_mapel }}</div>
            <div class="text-sm opacity-85 mt-1">Mata Pelajaran</div>
            <a href="{{ route('guru.mapel.nilai') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-book text-5xl opacity-25"></i>
    </div>

    {{-- Kelas --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_kelas }}</div>
            <div class="text-sm opacity-85 mt-1">Kelas</div>
            <a href="{{ route('guru.walikelas.kelas') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-door-open text-5xl opacity-25"></i>
    </div>

    {{-- Penilaian Selesai --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $persen }}%</div>
            <div class="text-sm opacity-85 mt-1">Penilaian Selesai</div>
            <a href="{{ route('guru.nilaiakhir') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-check-circle text-5xl opacity-25"></i>
    </div>

</div>

{{-- CHART SECTION --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

    {{-- Chart: Siswa per Kelas --}}
    <div class="card">
        <div class="card-header">
            <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
                <i class="fa fa-chart-bar"></i> Siswa per Kelas
            </span>
        </div>
        <div class="card-body">
            <canvas id="chartSiswaKelas" height="200"></canvas>
        </div>
    </div>

    {{-- Chart: Progress Penilaian --}}
    <div class="card">
        <div class="card-header">
            <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
                <i class="fa fa-chart-pie"></i> Progress Penilaian
            </span>
        </div>
        <div class="card-body" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="chartPenilaian" height="200"></canvas>
        </div>
    </div>

</div>

{{-- Chart: Rata-rata Nilai per Mapel --}}
<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
            <i class="fa fa-chart-line"></i> Rata-rata Nilai per Mata Pelajaran
        </span>
    </div>
    <div class="card-body">
        <canvas id="chartNilaiMapel" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const siswaPerKelas  = @json($siswa_per_kelas);
    const nilaiPerMapel  = @json($nilai_per_mapel);
    const persen         = {{ $persen }};

    const colors = ['#1a3a6c','#1e4d8c','#2563a8','#3b82c4','#60a5e0','#93c5f8'];

    // ── Chart 1: Bar - Siswa per Kelas ──
    new Chart(document.getElementById('chartSiswaKelas'), {
        type: 'bar',
        data: {
            labels: siswaPerKelas.length ? siswaPerKelas.map(k => k.nama) : ['Belum ada data'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: siswaPerKelas.length ? siswaPerKelas.map(k => k.total) : [0],
                backgroundColor: colors,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} siswa` } }
            },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── Chart 2: Doughnut - Progress Penilaian ──
    new Chart(document.getElementById('chartPenilaian'), {
        type: 'doughnut',
        data: {
            labels: ['Sudah Dinilai', 'Belum Dinilai'],
            datasets: [{
                data: [persen, 100 - persen],
                backgroundColor: ['#1a3a6c', '#e8edf5'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 16 } },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw}%` } }
            }
        },
        plugins: [{
            id: 'centerText',
            afterDraw(chart) {
                const { ctx, chartArea: { width, height, left, top } } = chart;
                ctx.save();
                ctx.font = 'bold 28px Segoe UI';
                ctx.fillStyle = '#1a3a6c';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText(persen + '%', left + width / 2, top + height / 2);
                ctx.restore();
            }
        }]
    });

    // ── Chart 3: Bar - Rata-rata Nilai per Mapel ──
    new Chart(document.getElementById('chartNilaiMapel'), {
        type: 'bar',
        data: {
            labels: nilaiPerMapel.length ? nilaiPerMapel.map(m => m.nama) : ['Belum ada data'],
            datasets: [{
                label: 'Rata-rata Nilai',
                data: nilaiPerMapel.length ? nilaiPerMapel.map(m => m.rata) : [0],
                backgroundColor: colors,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw}` } }
            },
            scales: {
                y: { beginAtZero: true, max: 100, grid: { color: '#f0f0f0' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endpush

@endsection