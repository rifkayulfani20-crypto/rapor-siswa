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
            <select class="per-page" id="tapelFilter" onchange="pindahTapel(this.value)" style="margin-left:8px;">
                <option value="">-- Semua Tahun Ajaran --</option>
                @foreach($tapelList as $t)
                <option value="{{ $t->id }}" {{ (string) $tapelFilterId === (string) $t->id ? 'selected' : '' }}>
                    {{ $t->nama }} {{ $t->semester }}
                </option>
                @endforeach
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
                        <th>Tahun Ajaran</th>
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
                        <td>{{ $p->tahunPelajaran->nama ?? '-' }} {{ $p->tahunPelajaran->semester ?? '' }}</td>
                        <td>{{ $p->mataPelajaran->kkm ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $p->sudah_diinput ? 'badge-success' : 'badge-danger' }}">
                                {{ $p->sudah_diinput ? 'Sudah Diinput' : 'Belum Diinput' }}
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
                        <td colspan="7" style="text-align:center;color:#7f8c8d;padding:30px;">
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
function pindahTapel(tapelId) {
    const url = new URL(window.location.href);
    if (tapelId) {
        url.searchParams.set('tapel_id', tapelId);
    } else {
        url.searchParams.delete('tapel_id');
    }
    window.location.href = url.toString();
}

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