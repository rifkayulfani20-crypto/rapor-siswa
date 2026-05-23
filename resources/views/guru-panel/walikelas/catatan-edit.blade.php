
@extends('layouts.guru')
@section('title', 'Input Catatan - ' . $kelas->nama)
@section('content')

<div class="page-title">Catatan - Kelas {{ $kelas->nama }}</div>

{{-- Info Kelas --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:16px 20px;border-left:4px solid #3498db;">
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
        <div style="font-weight:600;"><i class="fas fa-sticky-note"></i> Input Catatan Wali Kelas</div>
        <a href="{{ route('guru.walikelas.catatan') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.walikelas.catatan.update', $kelas->id) }}">
            @csrf @method('PUT')

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th style="width:120px;">NIS</th>
                            <th style="width:180px;">Nama</th>
                            <th style="width:50px;">L/P</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelas->siswas as $i => $siswa)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                <textarea name="catatan[]" class="form-control" rows="3"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Masukkan catatan untuk siswa ini...">{{ old('catatan.'.$i) }}</textarea>
                            </td>
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

            @if($kelas->siswas->count() > 0)
            <div style="margin-top:16px;">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan Catatan
                </button>
            </div>
            @endif

        </form>
    </div>
</div>

@endsection