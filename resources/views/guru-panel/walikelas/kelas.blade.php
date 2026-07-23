@extends('layouts.guru')
@section('title', 'Data Kelas Saya')
@section('content')

<div class="page-title">Data Kelas Saya</div>

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
            <table id="kelasTable">
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
                    @forelse($kelass as $i => $kelas)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $kelas->nama }}</td>
                        <td>{{ $kelas->waliKelas->nama ?? '-' }}</td>
                        <td>{{ $kelas->tahunPelajaran->nama ?? '-' }} - Semester {{ $kelas->tahunPelajaran->semester ?? '-' }}</td>
                        <td>
                            <a href="{{ route('guru.walikelas.kelas.siswa', $kelas->id) }}"
                               class="btn btn-success btn-sm" title="Lihat Siswa">
                               <i class="fas fa-users"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#7f8c8d;padding:30px;">
                            <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            Anda tidak memiliki kelas
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
    const rows    = document.querySelectorAll('#kelasTable tbody tr');
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