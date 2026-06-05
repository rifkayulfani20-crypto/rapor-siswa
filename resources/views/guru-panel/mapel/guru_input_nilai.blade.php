@extends('layouts.guru')
@section('title', 'Input Nilai')
@section('content')

<div class="page-title">Input Nilai Pelajaran</div>

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
            <input type="hidden" name="mata_pelajaran_id" value="{{ $pembelajaran->mata_pelajaran_id }}">
            <input type="hidden" id="kkm-value" value="{{ $pembelajaran->mataPelajaran->kkm ?? 75 }}">

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
                            <th style="width:80px;text-align:center;">Nilai Akhir</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $i => $siswa)
                        @php $nilai = $nilais[$siswa->id] ?? null; @endphp
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $siswa->nis }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->jenis_kelamin }}</td>
                            <td>
                                <input type="hidden" name="nilai[{{ $siswa->id }}][siswa_id]" value="{{ $siswa->id }}">
                                <input type="number" name="nilai[{{ $siswa->id }}][pengetahuan]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.pengetahuan', $nilai->nilai_pengetahuan ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100"
                                       oninput="hitungRow('{{ $siswa->id }}')">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][keterampilan]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.keterampilan', $nilai->nilai_keterampilan ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100"
                                       oninput="hitungRow('{{ $siswa->id }}')">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][pts]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.pts', $nilai->nilai_pts ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100"
                                       oninput="hitungRow('{{ $siswa->id }}')">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][pas]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.pas', $nilai->nilai_pas ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100"
                                       oninput="hitungRow('{{ $siswa->id }}')">
                            </td>
                            <td style="text-align:center;">
                                <span id="na-{{ $siswa->id }}" style="font-weight:700;font-size:13px;color:#2c3e50;">-</span>
                            </td>
                            <td>
                                <textarea name="nilai[{{ $siswa->id }}][deskripsi]" id="desk-{{ $siswa->id }}" class="form-control" rows="2"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Otomatis terisi saat nilai diinput...">{{ old('nilai.'.$siswa->id.'.deskripsi', $nilai->deskripsi ?? '') }}</textarea>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align:center;color:#7f8c8d;padding:30px;">
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

<script>
var kkm = parseFloat(document.getElementById('kkm-value').value) || 75;

function getDeskripsi(na) {
    if (na >= 90) return 'Menunjukkan penguasaan materi yang sangat baik serta memiliki keterampilan yang sangat memuaskan dan membanggakan.';
    if (na >= 80) return 'Menunjukkan penguasaan materi yang baik serta memiliki keterampilan yang sangat memuaskan.';
    if (na >= kkm) return 'Menunjukkan penguasaan materi yang cukup baik serta memiliki keterampilan yang memuaskan.';
    if (na >= 60) return 'Menunjukkan penguasaan materi yang masih kurang dan perlu bimbingan lebih intensif untuk mencapai ketuntasan.';
    return 'Menunjukkan penguasaan materi yang sangat kurang dan memerlukan bimbingan serta remedial segera.';
}

function hitungRow(siswaId) {
    var pEl   = document.querySelector('input[name="nilai[' + siswaId + '][pengetahuan]"]');
    var kEl   = document.querySelector('input[name="nilai[' + siswaId + '][keterampilan]"]');
    var ptsEl = document.querySelector('input[name="nilai[' + siswaId + '][pts]"]');
    var pasEl = document.querySelector('input[name="nilai[' + siswaId + '][pas]"]');
    var naEl  = document.getElementById('na-' + siswaId);
    var deskEl = document.getElementById('desk-' + siswaId);

    if (!naEl || !deskEl) return;

    var pFilled   = pEl.value.trim() !== '';
    var kFilled   = kEl.value.trim() !== '';
    var ptsFilled = ptsEl.value.trim() !== '';
    var pasFilled = pasEl.value.trim() !== '';

    if (pFilled && kFilled && ptsFilled && pasFilled) {
        var p   = parseFloat(pEl.value) || 0;
        var k   = parseFloat(kEl.value) || 0;
        var pts = parseFloat(ptsEl.value) || 0;
        var pas = parseFloat(pasEl.value) || 0;
        var na  = (p + k + pts + pas) / 4;

        naEl.textContent = na.toFixed(2);
        naEl.style.color = na >= kkm ? '#1e8449' : '#c0392b';
        deskEl.value = getDeskripsi(na);
        deskEl.style.background = na >= kkm ? '#f0faf4' : '#fdecea';
        deskEl.style.borderColor = na >= kkm ? '#2ecc71' : '#e74c3c';
    } else if (pFilled || kFilled || ptsFilled || pasFilled) {
        naEl.textContent = '...';
        naEl.style.color = '#e67e22';
    } else {
        naEl.textContent = '-';
        naEl.style.color = '#2c3e50';
        deskEl.style.background = '';
        deskEl.style.borderColor = '';
    }
}

// Hitung saat halaman load jika nilai sudah ada dari DB
window.onload = function() {
    @foreach($siswas as $siswa)
    hitungRow('{{ $siswa->id }}');
    @endforeach
};
</script>

@endsection