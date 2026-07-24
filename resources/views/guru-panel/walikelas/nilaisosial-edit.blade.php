@extends('layouts.guru')
@section('title', 'Input Nilai Sosial - ' . $kelas->nama)
@section('content')

<div class="page-title">Nilai Sosial - Kelas {{ $kelas->nama }}</div>

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
                <td style="padding:3px 0;">: <strong>{{ $kelas->tahunPelajaran->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td style="padding:3px 0;color:#555;">Semester</td>
                <td style="padding:3px 0;">: <strong>{{ $kelas->tahunPelajaran->semester ?? '-' }}</strong></td>
            </tr>
        </table>
    </div>
</div>

{{-- Form --}}
<div class="card">
    <div class="card-header">
        <div style="font-weight:600;"><i class="fas fa-edit"></i> Input Nilai Sosial</div>
        <a href="{{ route('guru.walikelas.nilaiSosial') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.walikelas.nilaiSosial.update', $kelas->id) }}">
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
                        @php $existing = $sikapData->get($siswa->id); @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">
                                @php $predikatTerpilih = old('predikat.'.$i, $existing->predikat_sosial ?? ''); @endphp
                                <select name="predikat[]" class="form-control predikat-select" style="font-size:12px;padding:6px 8px;">
                                    <option value="">-- Pilih --</option>
                                    <option value="A (Sangat Baik)" {{ $predikatTerpilih == 'A (Sangat Baik)' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                    <option value="B (Baik)"        {{ $predikatTerpilih == 'B (Baik)'        ? 'selected' : '' }}>B (Baik)</option>
                                    <option value="C (Cukup)"       {{ $predikatTerpilih == 'C (Cukup)'       ? 'selected' : '' }}>C (Cukup)</option>
                                    <option value="D (Perlu Bimbingan)" {{ $predikatTerpilih == 'D (Perlu Bimbingan)' ? 'selected' : '' }}>D (Perlu Bimbingan)</option>
                                </select>
                            </td>
                            <td>
                                <textarea name="deskripsi[]" class="form-control deskripsi-input" rows="3"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Masukkan deskripsi">{{ old('deskripsi.'.$i, $existing->deskripsi_sosial ?? '') }}</textarea>
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

<script>
const deskripsiMap = {
    'A (Sangat Baik)'      : 'Peserta didik menunjukkan sikap sosial yang sangat baik, mampu bekerja sama, peduli, dan bertanggung jawab dalam kehidupan sehari-hari.',
    'B (Baik)'             : 'Peserta didik menunjukkan sikap sosial yang baik, cukup mampu bekerja sama dan bertanggung jawab dalam kehidupan sehari-hari.',
    'C (Cukup)'            : 'Peserta didik menunjukkan sikap sosial yang cukup, perlu bimbingan lebih lanjut dalam bekerja sama dan bertanggung jawab.',
    'D (Perlu Bimbingan)'  : 'Peserta didik menunjukkan sikap sosial yang kurang, perlu perhatian dan bimbingan intensif dari guru dan orang tua.',
};

document.querySelectorAll('.predikat-select').forEach(function(select) {
    select.addEventListener('change', function() {
        const row      = this.closest('tr');
        const textarea = row.querySelector('.deskripsi-input');
        if (textarea) {
            textarea.value = deskripsiMap[this.value] || '';
        }
    });
});
</script>

@endsection