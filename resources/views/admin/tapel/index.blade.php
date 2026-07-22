@extends('layouts.app')

@section('content')
<div class="page-title">Tahun Pelajaran</div>

<div class="card">
    <div class="card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('tapel.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tahun Pelajaran
            </a>
        </div>
    </div>
    <div class="card-body">

        <div class="table-toolbar">
            <div style="display:flex;align-items:center;gap:8px;">
                <select class="per-page" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page',10)==10?'selected':'' }}>10</option>
                    <option value="25" {{ request('per_page',10)==25?'selected':'' }}>25</option>
                    <option value="50" {{ request('per_page',10)==50?'selected':'' }}>50</option>
                </select>
            </div>
            <input type="text" class="search-box" placeholder="Search..." id="searchInput"
                   onkeyup="liveSearch(this.value)">
        </div>

        <div class="table-wrapper">
            <table id="tapelTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th>Semester</th>
                        <th>Tempat Pembagian</th>
                        <th>Tanggal Pembagian</th>
                        <th width="80">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tapels as $i => $tapel)
                    <tr>
                        <td>{{ $tapels->firstItem() + $i }}</td>
                        <td>{{ $tapel->nama }}</td>
                        <td>{{ $tapel->semester }}</td>
                        <td>{{ $tapel->tempat_pembagian ?? '-' }}</td>
                        <td>{{ $tapel->tanggal_pembagian ? \Carbon\Carbon::parse($tapel->tanggal_pembagian)->translatedFormat('j F Y') : '-' }}</td>
                        <td>
                            <span class="badge {{ $tapel->aktif ? 'badge-success' : 'badge-danger' }}">
                                {{ $tapel->aktif ? 'AKTIF' : 'NONAKTIF' }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <a href="{{ route('tapel.edit', $tapel->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{ route('tapel.kenaikan.form', $tapel->id) }}" class="btn btn-success btn-sm" title="Naikkan Kelas">
                                    <i class="fa fa-arrow-up"></i>
                                </a>
                                <form method="POST" action="{{ route('tapel.destroy', $tapel->id) }}"
                                      style="display:inline"
                                      onsubmit="return confirm('Hapus tahun pelajaran {{ addslashes($tapel->nama) }}?')">
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
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data tahun pelajaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $tapels->firstItem() ?? 0 }}–{{ $tapels->lastItem() ?? 0 }}
                dari {{ $tapels->total() }} data
            </div>
            <div class="pagination">
                {{ $tapels->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function liveSearch(keyword) {
    keyword = keyword.toLowerCase();
    document.querySelectorAll('#tapelTable tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(keyword) ? '' : 'none';
    });
}
function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush