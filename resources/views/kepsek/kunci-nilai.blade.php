@extends('layouts.kepsek_app')

@section('content')
<div class="page-title">Kunci Nilai</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- MODAL KUNCI --}}
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

{{-- TABEL SEMUA TAPEL --}}
<div class="card">
    <div class="card-header">
        <span style="font-weight:600;font-size:14px;"><i class="fa fa-key"></i> Daftar Tahun Pelajaran</span>
        <a href="{{ route('kepsek.dashboard') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
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
                        <th>Kelas Terdampak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tapels as $i => $tapel)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $tapel->nama }}</strong></td>
                        <td>{{ $tapel->semester }}</td>
                        <td>
                            @if($tapel->aktif)
                                <span class="badge badge-success"><i class="fa fa-check-circle"></i> Aktif</span>
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
                            <span class="badge badge-info">
                                {{ $tapel->kelas_count }} Kelas
                            </span>
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
                        <td colspan="7" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada tahun pelajaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Keterangan --}}
        <div style="margin-top:20px;padding:14px 16px;background:#f8fafc;border-radius:10px;border:1px solid #e2e8f0;">
            <div style="font-weight:600;font-size:12px;color:#475569;margin-bottom:8px;"><i class="fa fa-info-circle text-blue-500 mr-1"></i> Keterangan</div>
            <div style="display:flex;flex-wrap:wrap;gap:16px;font-size:12px;color:#64748b;">
                <div><span class="badge badge-danger" style="margin-right:6px;"><i class="fa fa-lock"></i> Terkunci</span> Guru tidak dapat mengedit nilai pada tahun pelajaran ini</div>
                <div><span class="badge badge-success" style="margin-right:6px;"><i class="fa fa-lock-open"></i> Terbuka</span> Guru dapat mengedit nilai pada tahun pelajaran ini</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
document.getElementById('modalKunci').addEventListener('click', function(e) {
    if (e.target === this) tutupModalKunci();
});
document.getElementById('modalBukaKunci').addEventListener('click', function(e) {
    if (e.target === this) tutupModalBukaKunci();
});
</script>
@endpush