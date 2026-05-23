@extends('layouts.guru')
@section('title', 'Data Siswa Kelas ' . $kelas->nama)
@section('content')

<div class="page-title">Data Siswa Kelas {{ $kelas->nama }}</div>

{{-- Info Kelas --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="display:flex;gap:30px;flex-wrap:wrap;">
        <div>
            <div style="font-size:11px;color:#7f8c8d;text-transform:uppercase;letter-spacing:1px;">Kelas</div>
            <div style="font-size:15px;font-weight:700;color:#2c3e50;">{{ $kelas->nama }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:#7f8c8d;text-transform:uppercase;letter-spacing:1px;">Wali Kelas</div>
            <div style="font-size:15px;font-weight:700;color:#2c3e50;">{{ $kelas->waliKelas->nama ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:#7f8c8d;text-transform:uppercase;letter-spacing:1px;">Tahun Pelajaran</div>
            <div style="font-size:15px;font-weight:700;color:#2c3e50;">{{ $kelas->tahunPelajaran->tahun_pelajaran ?? '-' }} - Semester {{ $kelas->tahunPelajaran->semester ?? '-' }}</div>
        </div>
        <div>
            <div style="font-size:11px;color:#7f8c8d;text-transform:uppercase;letter-spacing:1px;">Jumlah Siswa</div>
            <div style="font-size:15px;font-weight:700;color:#3498db;">{{ $kelas->siswas->count() }} Siswa</div>
        </div>
    </div>
</div>

{{-- Tabel Siswa --}}
<div class="card">
    <div class="card-header">
        <div style="font-weight:600;"><i class="fas fa-users"></i> Daftar Siswa</div>
        <a href="{{ route('guru.walikelas.kelas') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
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
            <table id="siswaTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat, Tanggal Lahir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas->siswas as $i => $siswa)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $siswa->nisn ?? '-' }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>
                            @if($siswa->jenis_kelamin == 'L')
                                <span class="badge badge-success">Laki-laki</span>
                            @else
                                <span class="badge" style="background:#e91e8c;color:white;">Perempuan</span>
                            @endif
                        </td>
                        <td>{{ $siswa->tempat_lahir ?? '-' }}, {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#7f8c8d;padding:30px;">
                            <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                            Belum ada siswa di kelas ini
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
    const rows    = document.querySelectorAll('#siswaTable tbody tr');
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
        `Menampilkan ${visible} dari ${rows.length} siswa`;
}

filterTable();
</script>

@endsection