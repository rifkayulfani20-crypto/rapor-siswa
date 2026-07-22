@extends('layouts.app')

@section('content')
<div class="page-title">Data Kelas</div>

<div class="card">
    <div class="card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Kelas
            </a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-toolbar" style="flex-wrap:wrap;gap:10px;">
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <select class="per-page" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page',10)==10?'selected':'' }}>10</option>
                    <option value="25" {{ request('per_page',10)==25?'selected':'' }}>25</option>
                    <option value="50" {{ request('per_page',10)==50?'selected':'' }}>50</option>
                </select>

                <select class="form-control" style="min-width:220px;" onchange="filterTapel(this.value)">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tapelList as $t)
                        <option value="{{ $t->id }}" {{ (string) $tapelFilterId === (string) $t->id ? 'selected' : '' }}>
                            {{ $t->nama }} {{ $t->semester }} {{ $t->aktif ? '(Aktif)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="text" class="search-box" placeholder="Search..." id="searchInput"
                   onkeyup="liveSearch(this.value)">
        </div>

        <div class="table-wrapper">
            <table id="kelasTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th>Jumlah Siswa</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $i => $k)
                    <tr @if($k->siswas_count === 0) style="opacity:0.55;" @endif>
                        <td>{{ $kelas->firstItem() + $i }}</td>
                        <td>{{ $k->nama }}</td>
                        <td>{{ $k->tingkat }}</td>
                        <td>{{ $k->waliKelas->nama ?? '-' }}</td>
                        <td>{{ $k->tahunPelajaran->nama ?? '-' }} {{ $k->tahunPelajaran->semester ?? '' }}</td>
                        <td>
                            @if($k->siswas_count === 0)
                                <span style="display:inline-block;padding:2px 10px;border-radius:10px;background:#f1f5f9;color:#94a3b8;font-size:12px;">Kosong</span>
                            @else
                                {{ $k->siswas_count }} siswa
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('kelas.destroy', $k->id) }}"
                                      style="display:inline"
                                      onsubmit="return confirm('Hapus kelas {{ addslashes($k->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data kelas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $kelas->firstItem() ?? 0 }}–{{ $kelas->lastItem() ?? 0 }}
                dari {{ $kelas->total() }} data
            </div>
            <div class="pagination">
                {{ $kelas->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function liveSearch(keyword) {
    keyword = keyword.toLowerCase();
    document.querySelectorAll('#kelasTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
}
function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
function filterTapel(val) {
    const url = new URL(window.location.href);
    if (val) {
        url.searchParams.set('tapel_id', val);
    } else {
        url.searchParams.delete('tapel_id');
    }
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush