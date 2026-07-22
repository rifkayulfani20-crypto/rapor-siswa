@extends('layouts.app')

@section('content')
<div class="page-title">Data Siswa</div>

<div class="card">
    <div class="card-header">
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="{{ route('siswa.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Siswa
            </a>
            <button type="button" class="btn btn-success" onclick="document.getElementById('importModal').style.display='flex'">
                <i class="fa fa-file-import"></i> Import Excel/CSV
            </button>
            <a href="{{ route('siswa.export') }}" class="btn" style="background:#17a2b8;color:#fff;">
                <i class="fa fa-file-export"></i> Export Excel/CSV
            </a>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <a href="#" class="btn btn-info btn-sm" title="Info">
                <i class="fa fa-info"></i>
            </a>
        </div>
    </div>
    <div class="card-body">

        @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;">
            <i class="fa fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('import_errors') && count(session('import_errors')) > 0)
        <div class="alert alert-danger" style="margin-bottom:16px;">
            <i class="fa fa-exclamation-circle"></i> Beberapa baris tidak berhasil diimpor:
            <ul style="margin:6px 0 0;padding-left:18px;">
                @foreach(session('import_errors') as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Toolbar --}}
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

        {{-- Table --}}
        <div class="table-wrapper">
            <table id="siswaTable">
                <thead>
                    <tr>
                        <th width="40">#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>NIS</th>
                        <th>NISN</th>
                        <th>Jenis Kelamin</th>
                        <th>TTL</th>
                        <th>Telepon</th>
                        <th width="80">Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $i => $siswa)
                    <tr>
                        <td>{{ $siswas->firstItem() + $i }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->kelas->nama ?? '-' }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nisn }}</td>
                        <td>{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('j F Y') : '-' }}</td>
                        <td>{{ $siswa->no_hp_ortu ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $siswa->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ strtoupper($siswa->status) }}
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;gap:4px;">
                                {{-- Detail --}}
                                <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-success btn-sm" title="Detail">
                                   <i class="fa fa-list"></i>
                                </a>
                                {{-- Edit --}}
                                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {{-- Hapus --}}
                                <form method="POST" action="{{ route('siswa.destroy', $siswa->id) }}"
                                      style="display:inline"
                                      onsubmit="return confirm('Hapus data siswa {{ addslashes($siswa->nama) }}?')">
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
                        <td colspan="10" style="text-align:center;color:#7f8c8d;padding:40px">
                            <i class="fa fa-inbox fa-2x"></i><br><br>Belum ada data siswa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Info & Pagination --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:8px;">
            <div style="font-size:12px;color:#7f8c8d;">
                Menampilkan {{ $siswas->firstItem() ?? 0 }}–{{ $siswas->lastItem() ?? 0 }}
                dari {{ $siswas->total() }} data
            </div>
            <div class="pagination">
                {{ $siswas->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>

{{-- Modal Import CSV --}}
<div id="importModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);align-items:center;justify-content:center;z-index:1000;">
    <div style="background:#fff;border-radius:10px;padding:20px 24px;width:420px;max-width:90%;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <span style="font-weight:700;font-size:14px;color:#2c3e50;"><i class="fa fa-file-import"></i> Import Data Siswa</span>
            <span style="cursor:pointer;color:#999;" onclick="document.getElementById('importModal').style.display='none'"><i class="fa fa-times"></i></span>
        </div>
        <p style="font-size:12px;color:#666;margin-bottom:12px;">
            Unggah file CSV untuk menambahkan banyak siswa sekaligus, tidak perlu isi form satu per satu.
            Belum punya file? <a href="{{ route('siswa.import.template') }}">Unduh template CSV</a> dulu, isi datanya di Excel/Spreadsheet, lalu simpan/export ulang sebagai CSV.
        </p>
        <form method="POST" action="{{ route('siswa.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".csv,.txt" required
                style="width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;font-size:13px;margin-bottom:14px;">
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn btn-primary" style="flex:1;"><i class="fa fa-upload"></i> Proses Import</button>
                <button type="button" class="btn" style="background:#ddd;color:#555;" onclick="document.getElementById('importModal').style.display='none'">Batal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let searchTimeout;
function liveSearch(keyword) {
    // Debounce: tunggu 500ms setelah user berhenti mengetik,
    // baru kirim kata kunci ke server lewat query string ?search=...
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const url = new URL(window.location.href);
        if (keyword) {
            url.searchParams.set('search', keyword);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.set('page', 1); // reset ke halaman 1 tiap kali keyword berubah
        window.location.href = url.toString();
    }, 500);
}

function changePerPage(val) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', val);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}
</script>   
@endpush