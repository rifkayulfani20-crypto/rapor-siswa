@extends('layouts.app')
@section('content')

<div class="page-title">Data Guru</div>

<div class="card">
    <div class="card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('guru.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Guru
            </a>
        </div>
        <div>
            <a href="#" class="btn btn-info btn-sm" title="Info">
                <i class="fa fa-info"></i>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-toolbar">
            <div style="display:flex;align-items:center;gap:8px;">
                <select class="per-page" onchange="changePerPage(this.value)">
                    <option value="10"  {{ request('per_page',10)==10  ?'selected':'' }}>10</option>
                    <option value="25"  {{ request('per_page',10)==25  ?'selected':'' }}>25</option>
                    <option value="50"  {{ request('per_page',10)==50  ?'selected':'' }}>50</option>
                    <option value="100" {{ request('per_page',10)==100 ?'selected':'' }}>100</option>
                </select>
            </div>
            <input type="text" class="search-box" placeholder="Search..."
                   id="searchInput" onkeyup="liveSearch(this.value)">
        </div>

        <div class="table-wrapper">
            <table id="guruTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama Guru</th>
                        <th>Jenis Kelamin</th>
                        <th>NIP</th>
                        <th>NUPTK</th>
                        <th>TTL</th>
                        <th>Telepon</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gurus as $i => $guru)
                    <tr>
                        <td>{{ $gurus->firstItem() + $i }}</td>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $guru->nip ?? '-' }}</td>
                        <td>{{ $guru->nuptk ?? '-' }}</td>
                        <td>
                            {{ $guru->tempat_lahir ?? '-' }},
                            {{ $guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('j F Y') : '-' }}
                        </td>
                        <td>{{ $guru->no_hp ?? '-' }}</td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                <a href="{{ route('guru.edit', $guru) }}"
                                   class="btn btn-primary btn-sm"
                                   style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                                   title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('guru.destroy', $guru) }}"
                                      style="display:inline;"
                                      onsubmit="return confirm('Hapus data guru {{ addslashes($guru->nama) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                                            title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;color:#7f8c8d;padding:40px;">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data guru
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $gurus->firstItem() ?? 0 }}–{{ $gurus->lastItem() ?? 0 }}
                dari {{ $gurus->total() }} data
            </div>
            <div class="pagination">
                {{ $gurus->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function liveSearch(keyword) {
    keyword = keyword.toLowerCase();
    document.querySelectorAll('#guruTable tbody tr').forEach(row => {
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