@extends('layouts.guru')
@section('title', 'Input Nilai Pelajaran')
@section('content')

<div class="page-title">Input Nilai Pelajaran</div>

@if(!isset($pembelajaran))
{{-- LIST PEMBELAJARAN --}}
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
                            <a href="{{ route('guru.mapel.nilai', ['pembelajaran' => $p->id]) }}"
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

@else
{{-- FORM INPUT NILAI --}}

{{-- Info --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:16px 20px;border-left:4px solid #3498db;">
        <table style="font-size:13px;border-collapse:collapse;">
            <tr>
                <td style="padding:3px 0;color:#555;width:150px;">Mata Pelajaran</td>
                <td style="padding:3px 0;">: <strong>{{ ucwords($pembelajaran->mataPelajaran->nama ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Kelas</td>
                <td style="padding:3px 0;">: <strong>{{ $pembelajaran->kelas->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">KKM</td>
                <td style="padding:3px 0;">: <strong>{{ $pembelajaran->mataPelajaran->kkm ?? '-' }}</strong></td>
            </tr>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div style="font-weight:600;"><i class="fas fa-edit"></i> Input Nilai Siswa</div>
        <a href="{{ route('guru.mapel.nilai') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.mapel.nilai.simpan') }}">
            @csrf
            <input type="hidden" name="pembelajaran_id" value="{{ $pembelajaran->id }}">

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th style="width:120px;">NIS</th>
                            <th>Nama</th>
                            <th style="width:50px;">L/P</th>
                            <th style="width:100px;text-align:center;">Pengetahuan</th>
                            <th style="width:100px;text-align:center;">Keterampilan</th>
                            <th style="width:80px;text-align:center;">PTS</th>
                            <th style="width:80px;text-align:center;">PAS</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $i => $siswa)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                <input type="number" name="nilai_pengetahuan[]" min="0" max="100"
                                       value="{{ old('nilai_pengetahuan.'.$i, $siswa->nilai->nilai_pengetahuan ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;"
                                       placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai_keterampilan[]" min="0" max="100"
                                       value="{{ old('nilai_keterampilan.'.$i, $siswa->nilai->nilai_keterampilan ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;"
                                       placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai_pts[]" min="0" max="100"
                                       value="{{ old('nilai_pts.'.$i, $siswa->nilai->nilai_pts ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;"
                                       placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai_pas[]" min="0" max="100"
                                       value="{{ old('nilai_pas.'.$i, $siswa->nilai->nilai_pas ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;"
                                       placeholder="0-100">
                            </td>
                            <td>
                                <textarea name="deskripsi[]" class="form-control" rows="2"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Deskripsi nilai...">{{ old('deskripsi.'.$i, $siswa->nilai->deskripsi ?? '') }}</textarea>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align:center;color:#7f8c8d;padding:30px;">
                                <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                Belum ada siswa di kelas ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($siswas->count() > 0)
            <div style="margin-top:16px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Nilai
                </button>
            </div>
            @endif

        </form>
    </div>
</div>
@endif

<script>
function filterTable() {
    const input   = document.getElementById('searchInput') ? document.getElementById('searchInput').value.toLowerCase() : '';
    const perPage = document.getElementById('perPage') ? parseInt(document.getElementById('perPage').value) : 10;
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

    const info = document.getElementById('showingInfo');
    if (info) info.innerText = `Menampilkan ${visible} dari ${rows.length} data`;
}

if (document.getElementById('mapelTable')) filterTable();
</script>

@endsection