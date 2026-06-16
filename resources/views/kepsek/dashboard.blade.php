@extends('layouts.kepsek_app')

@section('content')
<div class="page-title">Dashboard Kepala Sekolah</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- MODAL KUNCI NILAI --}}
<div id="modalKunci" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6">
        <div class="text-center mb-4">
            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa fa-lock text-red-500 text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-base">Kunci Nilai?</h3>
            <p class="text-gray-500 text-sm mt-1">Guru tidak dapat mengedit nilai setelah dikunci.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="tutupModalKunci()"
                class="flex-1 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="submitKunci()"
                class="flex-1 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition">
                <i class="fa fa-lock mr-1"></i> Kunci
            </button>
        </div>
    </div>
</div>

{{-- MODAL BUKA KUNCI --}}
<div id="modalBukaKunci" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-6">
        <div class="text-center mb-4">
            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fa fa-lock-open text-green-500 text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-base">Buka Kunci Nilai?</h3>
            <p class="text-gray-500 text-sm mt-1">Guru dapat mengedit nilai kembali.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="tutupModalBukaKunci()"
                class="flex-1 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="submitBukaKunci()"
                class="flex-1 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white text-sm font-semibold transition">
                <i class="fa fa-lock-open mr-1"></i> Buka Kunci
            </button>
        </div>
    </div>
</div>

{{-- Form tersembunyi --}}
<form id="formKunci" method="POST" style="display:none"></form>
<form id="formBukaKunci" method="POST" style="display:none"></form>

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

{{-- TABEL TAPEL --}}
<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:14px;"><i class="fa fa-calendar-alt"></i> Daftar Tahun Pelajaran</span>
        <a href="{{ route('kepsek.nilai.akhir') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-list"></i> Lihat Nilai Akhir
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tahun Pelajaran</th>
                        <th>Semester</th>
                        <th>Status Aktif</th>
                        <th>Status Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tapels as $i => $tapel)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $tapel->nama }}</td>
                        <td>{{ $tapel->semester }}</td>
                        <td>
                            @if($tapel->aktif)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            @if($tapel->is_locked)
                                <span class="badge badge-danger"><i class="fa fa-lock"></i> Terkunci</span>
                            @else
                                <span class="badge badge-success"><i class="fa fa-lock-open"></i> Terbuka</span>
                            @endif
                        </td>
                        <td>
                            @if($tapel->is_locked)
                                <button type="button"
                                    onclick="bukaKunci('{{ route('kepsek.tapel.unlock', $tapel->id) }}')"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-lock-open"></i> Buka Kunci
                                </button>
                            @else
                                <button type="button"
                                    onclick="kunciNilai('{{ route('kepsek.tapel.lock', $tapel->id) }}')"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-lock"></i> Kunci Nilai
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada tahun pelajaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── MODAL KUNCI ──
function kunciNilai(url) {
    document.getElementById('formKunci').action = url;
    document.getElementById('formKunci').innerHTML = '@csrf';
    const modal = document.getElementById('modalKunci');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function tutupModalKunci() {
    const modal = document.getElementById('modalKunci');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function submitKunci() {
    document.getElementById('formKunci').submit();
}

// ── MODAL BUKA KUNCI ──
function bukaKunci(url) {
    document.getElementById('formBukaKunci').action = url;
    document.getElementById('formBukaKunci').innerHTML = '@csrf';
    const modal = document.getElementById('modalBukaKunci');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function tutupModalBukaKunci() {
    const modal = document.getElementById('modalBukaKunci');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function submitBukaKunci() {
    document.getElementById('formBukaKunci').submit();
}

// ── TUTUP MODAL KLIK DI LUAR ──
document.getElementById('modalKunci').addEventListener('click', function(e) {
    if (e.target === this) tutupModalKunci();
});
document.getElementById('modalBukaKunci').addEventListener('click', function(e) {
    if (e.target === this) tutupModalBukaKunci();
});

// ── DATA GRAFIK ──
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