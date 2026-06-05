@extends('layouts.app')

@section('content')
<div class="page-title">Data Akun</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">Daftar Akun Pengguna</span>
    </div>
    <div class="card-body">

        <div class="table-toolbar">
            <div style="display:flex;align-items:center;gap:8px;">
                <select class="per-page" id="perPageSelect" onchange="changePerPage(this.value)">
                    <option value="10" {{ request('per_page',10)==10?'selected':'' }}>10</option>
                    <option value="25" {{ request('per_page',10)==25?'selected':'' }}>25</option>
                    <option value="50" {{ request('per_page',10)==50?'selected':'' }}>50</option>
                    <option value="100" {{ request('per_page',10)==100?'selected':'' }}>100</option>
                </select>
            </div>
            <input type="text" class="search-box" placeholder="Search..." id="searchInput"
                   value="{{ request('search') }}" onkeyup="liveSearch(this.value)">
        </div>

        <div class="table-wrapper">
            <table id="akunTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($akuns as $i => $akun)
                    <tr>
                        <td>{{ $akuns->firstItem() + $i }}</td>
                        <td>{{ $akun->name }}</td>
                        <td>{{ $akun->email }}</td>
                        <td>
                            <span class="badge {{ $akun->role === 'admin' ? 'badge-danger' : ($akun->role === 'guru' ? 'badge-warning' : 'badge-success') }}">
                                {{ strtoupper($akun->role) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.akun.edit', $akun->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data akun
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $akuns->firstItem() ?? 0 }}–{{ $akuns->lastItem() ?? 0 }}
                dari {{ $akuns->total() }} data
            </div>
            <div class="pagination">
                {{ $akuns->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function liveSearch(keyword) {
    keyword = keyword.toLowerCase();
    document.querySelectorAll('#akunTable tbody tr').forEach(row => {
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