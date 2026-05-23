@extends('layouts.guru')
@section('title', 'Input Nilai Pelajaran')
@section('content')

<div class="page-title">Input Nilai Pelajaran</div>

<div class="card">
    <div class="card-body">

        <div class="table-toolbar">
            <select class="per-page" id="perPage" onchange="filterTable()">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
            <input type="text" class="search-box" id="searchInput" onkeyup="filterTable()" placeholder="Search...">
        </div>

        <div class="table-wrapper">
            <table id="mapelTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>KKM</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelajarans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ ucwords($p->mataPelajaran->nama ?? '-') }}</td>
                        <td>{{ $p->kelas->nama ?? '-' }}</td>
                        <td>{{ $p->mataPelajaran->kkm ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $p->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('guru.mapel.nilai.input', $p->id) }}"
                               class="btn btn-primary btn-sm" title="Input Nilai">
                                <i class="fas fa-edit"></i> Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;color:#7f8c8d;padding:30px;">
                            <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            Anda tidak memiliki mata pelajaran
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:12px;font-size:12px;color:#7f8c8d;" id="showingInfo"></div>

    </div>
</div>

<script>
function filterTable() {
    const input   = document.getElementById('searchInput').value.toLowerCase();
    const perPage = parseInt(document.getElementById('perPage').value);
    const rows    = document.querySelectorAll('#mapelTable tbody tr');
    let visible   = 0;

    rows.forEach(row => {
        const text  = row.innerText.toLowerCase();
        const match = text.includes(input);
        if (match && visible < perPage) {
            row.style.display = '';
            visible++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('showingInfo').innerText =
        `Menampilkan ${visible} dari ${rows.length} data`;
}

filterTable();
</script>

@endsection