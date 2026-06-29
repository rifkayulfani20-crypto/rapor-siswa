@extends('layouts.app')

@section('content')
<div class="page-title">Data Akun</div>

<div class="card">
    <div class="card-header">
        <span class="font-semibold">Daftar Akun Pengguna</span>
    </div>
    <div class="card-body">

        {{-- Filter Role --}}
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;">
            <label style="font-size:14px;font-weight:500;">Filter Role:</label>
            <select onchange="filterRole(this.value)"
                style="border:1px solid #ccc;border-radius:8px;padding:6px 12px;font-size:13px;min-width:160px;">
                <option value="" {{ request('role') == '' ? 'selected' : '' }}>-- Semua --</option>
                <option value="admin"  {{ request('role') == 'admin'  ? 'selected' : '' }}>Admin</option>
                <option value="guru"   {{ request('role') == 'guru'   ? 'selected' : '' }}>Guru</option>
                <option value="siswa"  {{ request('role') == 'siswa'  ? 'selected' : '' }}>Siswa</option>
                <option value="kepsek" {{ request('role') == 'kepsek' ? 'selected' : '' }}>Kepsek</option>
            </select>
        </div>

        <div class="table-toolbar">
            <div style="display:flex;align-items:center;gap:8px;">
                <select class="per-page" id="perPageSelect" onchange="changePerPage(this.value)">
                    <option value="10"  {{ request('per_page',10)==10  ? 'selected' : '' }}>10</option>
                    <option value="25"  {{ request('per_page',10)==25  ? 'selected' : '' }}>25</option>
                    <option value="50"  {{ request('per_page',10)==50  ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page',10)==100 ? 'selected' : '' }}>100</option>
                </select>
            </div>

            {{-- Search: server-side via GET --}}
            <input type="text"
                   class="search-box"
                   placeholder="Search..."
                   id="searchInput"
                   value="{{ request('search') }}"
                   onkeyup="serverSearch(this.value)">
        </div>

        <div class="table-wrapper">
            <table id="akunTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($akuns as $i => $akun)
                    <tr>
                        <td>{{ $akuns->firstItem() + $i }}</td>
                        <td>{{ $akun->name }}</td>
                        <td>{{ $akun->email }}</td>
                        <td>
                            <span class="badge {{ 
                                $akun->role === 'admin'  ? 'badge-danger'  : 
                               ($akun->role === 'guru'   ? 'badge-warning' : 
                               ($akun->role === 'kepsek' ? 'badge-info'    : 'badge-success')) 
                            }}">
                                {{ strtoupper($akun->role) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <form method="POST" action="{{ route('admin.akun.updateRole', $akun->id) }}" style="margin:0">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" onchange="this.form.submit()"
                                        style="border:1px solid #ccc;border-radius:6px;padding:3px 6px;font-size:12px;min-width:85px;">
                                        <option value="admin"  {{ $akun->role === 'admin'  ? 'selected' : '' }}>Admin</option>
                                        <option value="guru"   {{ $akun->role === 'guru'   ? 'selected' : '' }}>Guru</option>
                                        <option value="siswa"  {{ $akun->role === 'siswa'  ? 'selected' : '' }}>Siswa</option>
                                        <option value="kepsek" {{ $akun->role === 'kepsek' ? 'selected' : '' }}>Kepsek</option>
                                    </select>
                                </form>
                                <a href="{{ route('admin.akun.edit', $akun->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
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
let searchTimeout = null;

// ✅ Server-side search — cari semua halaman, bukan hanya halaman ini
function serverSearch(keyword) {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const url = new URL(window.location.href);
        if (keyword.trim()) {
            url.searchParams.set('search', keyword.trim());
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.set('page', 1); // reset ke halaman 1
        window.location.href = url.toString();
    }, 500); // delay 500ms supaya tidak spam request
}

function filterRole(role) {
    const url = new URL(window.location.href);
    if (role) {
        url.searchParams.set('role', role);
    } else {
        url.searchParams.delete('role');
    }
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>
@endpush