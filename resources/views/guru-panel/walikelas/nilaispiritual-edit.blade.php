@extends('layouts.guru')
@section('title', 'Input Nilai Spiritual - ' . $kelas->nama)
@section('content')

<div class="page-title">Nilai Spiritual - Kelas {{ $kelas->nama }}</div>

{{-- Info Kelas --}}
<div class="card" style="margin-bottom:16px;">
    <div class="card-body" style="padding:16px 20px;">
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
        <div style="font-weight:600;"><i class="fas fa-edit"></i> Input Nilai Spiritual</div>
        <a href="{{ route('guru.walikelas.nilaiSpiritual') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.walikelas.nilaiSpiritual.update', $kelas->id) }}">
            @csrf @method('PUT')

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th style="width:120px;">NIS</th>
                            <th>Nama</th>
                            <th style="width:50px;">L/P</th>
                            <th style="width:180px;">Predikat</th>
                            <th>Deskripsi</th>
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
                                <select name="predikat[]" class="form-control" style="font-size:12px;padding:6px 8px;">
                                    <option value="">-- Pilih --</option>
                                    <option value="A (Sangat Baik)">A (Sangat Baik)</option>
                                    <option value="B (Baik)">B (Baik)</option>
                                    <option value="C (Cukup)">C (Cukup)</option>
                                    <option value="D (Perlu Bimbingan)">D (Perlu Bimbingan)</option>
                                </select>
                            </td>
                            <td>
                                <textarea name="deskripsi[]" class="form-control" rows="3"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Masukkan deskripsi">{{ old('deskripsi.'.$i) }}</textarea>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:#7f8c8d;padding:30px;">
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
                    <i class="fas fa-save"></i> Simpan Nilai
                </button>
            </div>
            @endif

        </form>
    </div>
</div>

@endsection