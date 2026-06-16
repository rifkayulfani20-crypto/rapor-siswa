@extends('layouts.app')

@section('content')
<h1 class="page-title">Dashboard</h1>

{{-- Grid Kartu --}}
<div class="grid grid-cols-2 gap-4 mb-6">

    {{-- Siswa --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_siswa }}</div>
            <div class="text-sm opacity-85 mt-1">Siswa</div>
            <a href="{{ route('siswa.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-user-graduate text-5xl opacity-25"></i>
    </div>

    {{-- Guru --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_guru }}</div>
            <div class="text-sm opacity-85 mt-1">Guru</div>
            <a href="{{ route('guru.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-users text-5xl opacity-25"></i>
    </div>

    {{-- Mata Pelajaran --}}
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_mapel }}</div>
            <div class="text-sm opacity-85 mt-1">Mata Pelajaran</div>
            <a href="{{ route('mapel.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-book text-5xl opacity-25"></i>
    </div>

    {{-- Kelas --}}
    <div class="bg-[#1e4d8c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $total_kelas }}</div>
            <div class="text-sm opacity-85 mt-1">Kelas</div>
            <a href="{{ route('kelas.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-door-open text-5xl opacity-25"></i>
    </div>

    {{-- Penilaian Selesai --}}
    @php
        $persen = ($total_siswa > 0 && $total_mapel > 0)
            ? round(($nilai_sudah_diinput ?? 0) / ($total_siswa * $total_mapel) * 100)
            : 53;
    @endphp
    <div class="bg-[#1a3a6c] text-white rounded-xl p-5 flex items-center justify-between">
        <div>
            <div class="text-4xl font-bold">{{ $persen }}%</div>
            <div class="text-sm opacity-85 mt-1">Penilaian Selesai</div>
            <a href="{{ route('nilai.index') }}" class="text-white/70 text-xs no-underline">Lihat detail &rsaquo;</a>
        </div>
        <i class="fa fa-check-circle text-5xl opacity-25"></i>
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

{{-- Chart: Rekap Data --}}
<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:13px;color:#1a3a6c;">
            <i class="fa fa-chart-line"></i> Rekap Data Sekolah
        </span>
    </div>
    <div class="card-body">
        <canvas id="chartRekap" height="100"></canvas>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ── Data dari Laravel ──
    const siswaPerKelas = @json($siswa_per_kelas ?? []);
    const totalSiswa    = {{ $total_siswa }};
    const totalGuru     = {{ $total_guru }};
    const totalMapel    = {{ $total_mapel }};
    const totalKelas    = {{ $total_kelas }};
    const persen        = {{ $persen }};

    const labels = siswaPerKelas.map(k => k.nama);
    const counts = siswaPerKelas.map(k => k.total);

    const colors = [
        '#1a3a6c','#1e4d8c','#2563a8','#3b82c4',
        '#60a5e0','#93c5f8','#bfdbfe','#dbeafe'
    ];

    // ── Chart 1: Bar - Siswa per Kelas ──
    new Chart(document.getElementById('chartSiswaKelas'), {
        type: 'bar',
        data: {
            labels: labels.length ? labels : ['Belum ada data'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: counts.length ? counts : [0],
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
                        label: ctx => ` ${ctx.raw} siswa`
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: '#f0f0f0' }
                },
                x: {
                    grid: { display: false }
                }
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
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 12 }, padding: 16 }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw}%`
                    }
                }
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

    // ── Chart 3: Bar Horizontal - Rekap Data ──
    new Chart(document.getElementById('chartRekap'), {
        type: 'bar',
        data: {
            labels: ['Siswa', 'Guru', 'Mata Pelajaran', 'Kelas'],
            datasets: [{
                label: 'Total',
                data: [totalSiswa, totalGuru, totalMapel, totalKelas],
                backgroundColor: ['#1a3a6c','#1e4d8c','#2563a8','#3b82c4'],
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw}`
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grid: { color: '#f0f0f0' }
                },
                y: {
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush

@endsection