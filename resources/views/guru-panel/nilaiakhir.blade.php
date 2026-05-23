@extends('layouts.guru')
@section('title', 'Nilai Akhir')
@section('content')

<div class="page-title">Data Nilai Akhir</div>

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
            <table id="nilaiakhirTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelajarans as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $p->nama ?? '-' }}</td>
                        <td>{{ optional($p->waliKelas)->nama ?? '-' }}</td>
                        <td>{{ optional($p->tahunPelajaran)->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('guru.nilaiakhir.detail', $p->id) }}" class="btn btn-primary btn-sm" title="Detail">
                                <i class="fas fa-list"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#7f8c8d;padding:30px;">
                            <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            Tidak ada data kelas
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
    const rows    = document.querySelectorAll('#nilaiakhirTable tbody tr');
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

    document.getElementById('showingInfo').innerText = `Menampilkan ${visible} dari ${rows.length} data`;
}

filterTable();
</script>

@endsection