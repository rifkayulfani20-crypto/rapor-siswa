@extends('layouts.app')

@section('content')
<div class="page-title">Mata Pelajaran</div>

<div class="card">
    <div class="card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('mapel.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Mata Pelajaran
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
            <table id="mapelTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Mapel</th>
                        <th>Kode</th>
                        <th>Kelompok</th>
                        <th>KKM</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mapels as $i => $mapel)
                    <tr>
                        <td>{{ $mapels->firstItem() + $i }}</td>
                        <td>{{ $mapel->nama }}</td>
                        <td>{{ $mapel->kode }}</td>
                        <td>{{ $mapel->kelompok ?? '-' }}</td>
                        <td>{{ $mapel->kkm }}</td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <a href="{{ route('mapel.edit', $mapel->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('mapel.destroy', $mapel->id) }}"
                                      style="display:inline"
                                      onsubmit="return confirm('Hapus mapel {{ addslashes($mapel->nama) }}?')">
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
                        <td colspan="6" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data mata pelajaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $mapels->firstItem() ?? 0 }}–{{ $mapels->lastItem() ?? 0 }}
                dari {{ $mapels->total() }} data
            </div>
            <div class="pagination">
                {{ $mapels->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function liveSearch(keyword) {
    keyword = keyword.toLowerCase();
    document.querySelectorAll('#mapelTable tbody tr').forEach(row => {
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