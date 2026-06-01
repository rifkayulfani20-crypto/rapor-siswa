@extends('layouts.guru')
@section('title', 'Input Ketidakhadiran - ' . $kelas->nama)
@section('content')

<div class="page-title">Ketidakhadiran - Kelas {{ $kelas->nama }}</div>

{{-- Info Kelas --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:16px 20px;border-left:4px solid #f39c12;">
        <table style="font-size:13px;border-collapse:collapse;">
            <tr>
                <td style="padding:3px 0;color:#555;width:130px;">Wali Kelas</td>
                <td style="padding:3px 0;">: <strong>{{ $kelas->waliKelas->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Tahun Pelajaran</td>
                <td style="padding:3px 0;">: <strong>{{ $kelas->tahunPelajaran->tahun_pelajaran ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Semester</td>
                <td style="padding:3px 0;">: <strong>{{ $kelas->tahunPelajaran->semester ?? '-' }} / {{ $kelas->tahunPelajaran->semester == 1 ? 'Ganjil' : 'Genap' }}</strong></td>
            </tr>
        </table>
    </div>
</div>

{{-- Form --}}
<div class="card">
    <div class="card-header">
        <div style="font-weight:600;"><i class="fas fa-calendar-times"></i> Input Ketidakhadiran</div>
        <a href="{{ route('guru.walikelas.ketidakhadiran') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.walikelas.ketidakhadiran.update', $kelas->id) }}">
            @csrf @method('PUT')

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th style="width:120px;">NIS</th>
                            <th>Nama</th>
                            <th style="width:50px;">L/P</th>
                            <th>Sakit</th>
                            <th>Izin</th>
                            <th>Tanpa Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas->siswas as $i => $siswa)
                        @php $hadir = $ketidakhadiranData[$siswa->id] ?? null; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                <input type="number" name="sakit[]" min="0"
                                       value="{{ old('sakit.'.$i, $hadir->sakit ?? 0) }}"
                                       class="form-control" style="font-size:13px;">
                            </td>
                            <td>
                                <input type="number" name="izin[]" min="0"
                                       value="{{ old('izin.'.$i, $hadir->izin ?? 0) }}"
                                       class="form-control" style="font-size:13px;">
                            </td>
                            <td>
                                <input type="number" name="tanpa_keterangan[]" min="0"
                                       value="{{ old('tanpa_keterangan.'.$i, $hadir->tanpa_keterangan ?? 0) }}"
                                       class="form-control" style="font-size:13px;">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:#7f8c8d;padding:30px;">
                                <i class="fas fa-inbox" style="font-size:24px;display:block;margin-bottom:8px;"></i>
                                Belum ada siswa di kelas ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($kelas->siswas->count() > 0)
            <div style="margin-top:16px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
            @endif

        </form>
    </div>
</div>

@endsection