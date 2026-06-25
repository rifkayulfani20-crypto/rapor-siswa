@extends('layouts.kepsek_app')

@section('content')
<div class="page-title">Dashboard Kepala Sekolah</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 gap-4 mb-6">

    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold leading-snug">{{ auth()->user()->name }}</div>
            <div class="text-sm opacity-85 mt-1">Kepala Sekolah</div>
            <a href="{{ route('kepsek.profil') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat profil ›</a>
        </div>
        <i class="fas fa-user-tie text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $totalKelas ?? 0 }}</div>
            <div class="text-sm opacity-85 mt-1">Total Kelas</div>
            <a href="{{ route('kepsek.nilai.akhir') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat detail ›</a>
        </div>
        <i class="fas fa-door-open text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $totalSiswa ?? 0 }}</div>
            <div class="text-sm opacity-85 mt-1">Total Siswa</div>
            <a href="{{ route('kepsek.nilai.akhir') }}" class="text-white/70 text-xs no-underline mt-4 block">Lihat nilai ›</a>
        </div>
        <i class="fas fa-users text-5xl opacity-25"></i>
    </div>

    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-xl font-bold leading-snug">{{ $tapelAktif->nama ?? '-' }}</div>
            <div class="text-sm opacity-85 mt-1">{{ $tapelAktif->semester ?? 'Tahun Pelajaran Aktif' }}</div>
            <span class="text-white/70 text-xs mt-4 block">
                @if($tapelAktif?->is_locked)
                    <i class="fa fa-lock mr-1"></i> Nilai Terkunci
                @else
                    <i class="fa fa-lock-open mr-1"></i> Nilai Terbuka
                @endif
            </span>
        </div>
        <i class="fas fa-calendar-alt text-5xl opacity-25"></i>
    </div>

</div>

{{-- CHART SECTION --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">

    <div class="card">
        <div class="card-header">
            <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
                <i class="fa fa-chart-bar"></i> Rata-rata Nilai per Kelas
            </span>
        </div>
        <div class="card-body">
            <canvas id="grafikRataRata" height="200"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
                <i class="fa fa-chart-pie"></i> Siswa Lulus / Tidak Lulus
            </span>
        </div>
        <div class="card-body" style="display:flex;align-items:center;justify-content:center;">
            <canvas id="grafikLulus" height="200"></canvas>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const grafikData = @json($grafikKelas);
const labels     = grafikData.map(d => d.nama);
const rataRata   = grafikData.map(d => d.rata_rata);
const lulus      = grafikData.map(d => d.lulus);
const tidakLulus = grafikData.map(d => d.tidak_lulus);
const colors     = ['#1a3a6c','#1e4d8c','#2563a8','#3b82c4','#60a5e0','#93c5f8'];

// ── Chart 1: Bar - Rata-rata Nilai per Kelas ──
new Chart(document.getElementById('grafikRataRata'), {
    type: 'bar',
    data: {
        labels: labels.length ? labels : ['Belum ada data'],
        datasets: [{
            label: 'Rata-rata Nilai',
            data: rataRata.length ? rataRata : [0],
            backgroundColor: colors,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` Rata-rata: ${ctx.raw}`
                }
            }
        },
        scales: {
            y: { beginAtZero: true, max: 100, grid: { color: '#f0f0f0' }, ticks: { font: { size: 11 } } },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});

// ── Chart 2: Doughnut - Total Lulus vs Tidak Lulus ──
const totalLulus      = lulus.reduce((a, b) => a + b, 0);
const totalTidakLulus = tidakLulus.reduce((a, b) => a + b, 0);
const totalSiswa      = totalLulus + totalTidakLulus;
const persenLulus     = totalSiswa > 0 ? Math.round((totalLulus / totalSiswa) * 100) : 0;

new Chart(document.getElementById('grafikLulus'), {
    type: 'doughnut',
    data: {
        labels: ['Lulus (≥75)', 'Tidak Lulus (<75)'],
        datasets: [{
            data: [totalLulus, totalTidakLulus],
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
            tooltip: { callbacks: { label: ctx => ` ${ctx.raw} siswa` } }
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
            ctx.fillText(persenLulus + '%', left + width / 2, top + height / 2 - 10);
            ctx.font = '12px Segoe UI';
            ctx.fillStyle = '#7f8c8d';
            ctx.fillText('Lulus', left + width / 2, top + height / 2 + 16);
            ctx.restore();
        }
    }]
});
</script>
@endpush