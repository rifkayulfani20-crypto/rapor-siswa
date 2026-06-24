@extends('layouts.app')
@section('title', 'Data Pembelajaran')
@section('content')

<div class="page-title">Data Pembelajaran</div>

<div class="card">
    <div class="card-body">

        {{-- Filter Tahun Pelajaran --}}
        <div style="margin-bottom:16px;">
            <form method="GET" action="{{ route('pembelajaran.index') }}" style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <label style="font-size:13px;font-weight:600;color:#2c3e50;">Filter Tahun Pelajaran:</label>
                <select name="tahun_pelajaran_id" onchange="this.form.submit()" style="padding:6px 12px;border:1px solid #ddd;border-radius:6px;font-size:13px;">
                    <option value="">-- Semua --</option>
                    @foreach($tapels as $tapel)
                        <option value="{{ $tapel->id }}"
                            {{ request('tahun_pelajaran_id') == $tapel->id ? 'selected' : '' }}>
                            {{ $tapel->nama }} {{ $tapel->semester }}
                        </option>
                    @endforeach
                </select>
               
            </form>
        </div>

        <div class="table-toolbar">
            <div style="display:flex; align-items:center; gap:10px;">
                <a href="{{ route('pembelajaran.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Pembelajaran
                </a>
                <label class="small">Tampilkan
                    <select class="per-page" onchange="changePerPage(this.value)">
                        @foreach([10,25,50,100] as $n)
                            <option value="{{ $n }}" {{ request('per_page',10)==$n ? 'selected' : '' }}>{{ $n }}</option>
                        @endforeach
                    </select> entri
                </label>
            </div>
            <input type="text" id="cari" placeholder="Search..." class="search-box">
        </div>

        <div class="table-wrapper">
            <table id="tbl">
                <thead>
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th style="width:80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelajaran as $i => $p)
                    <tr>
                        <td>{{ $pembelajaran->firstItem() + $i }}</td>
                        <td>{{ $p->guru->nama ?? '-' }}</td>
                        <td>{{ $p->mataPelajaran->nama ?? '-' }}</td>
                        <td>{{ $p->kelas->nama ?? '-' }}</td>
                        <td>
                            @if($p->status === 'Aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">{{ $p->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <a href="{{ route('pembelajaran.edit', $p) }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('pembelajaran.destroy', $p) }}"
                                    onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:30px; color:#7f8c8d;">
                            Belum ada data pembelajaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $pembelajaran->firstItem() ?? 0 }}–{{ $pembelajaran->lastItem() ?? 0 }}
                dari {{ $pembelajaran->total() }} data
            </div>
            {{ $pembelajaran->appends(request()->query())->links() }}
        </div>

    </div>
</div>

@push('scripts')
<script>
document.getElementById('cari').addEventListener('keyup', function () {
    const v = this.value.toLowerCase();
    document.querySelectorAll('#tbl tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(v) ? '' : 'none';
    });
});
function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush

@endsection