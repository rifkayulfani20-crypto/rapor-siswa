@extends('layouts.app')
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

        @if(session('error'))
            <div style="background:#fdf0f0;border:1px solid #e74c3c;border-left:4px solid #c0392b;color:#721c24;padding:14px 18px;border-radius:8px;margin-bottom:16px;font-size:13px;display:flex;align-items:center;gap:10px;">
                <i class="fas fa-lock" style="font-size:18px;"></i>
                <div><strong>Nilai Terkunci</strong><br>{{ session('error') }}</div>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('guru.mapel.nilai.simpan') }}">
            @csrf
            <input type="hidden" name="pembelajaran_id" value="{{ $pembelajaran->id }}">
            <input type="hidden" name="mata_pelajaran_id" value="{{ $pembelajaran->mata_pelajaran_id }}">

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
function getDeskripsi(na) {
    if (na >= 90) return 'Menunjukkan penguasaan materi yang sangat baik serta memiliki keterampilan yang sangat memuaskan dan membanggakan.';
    if (na >= 80) return 'Menunjukkan penguasaan materi yang baik serta memiliki keterampilan yang sangat memuaskan.';
    if (na >= 70) return 'Menunjukkan penguasaan materi yang cukup baik serta memiliki keterampilan yang memuaskan.';
    if (na >= 60) return 'Menunjukkan penguasaan materi yang cukup serta perlu meningkatkan keterampilan lebih lanjut.';
    return 'Menunjukkan penguasaan materi yang masih perlu ditingkatkan dan memerlukan bimbingan lebih lanjut.';
}

function hitungRow(siswaId) {
    var p   = parseFloat(document.querySelector('input[name="nilai[' + siswaId + '][pengetahuan]"]').value) || 0;
    var k   = parseFloat(document.querySelector('input[name="nilai[' + siswaId + '][keterampilan]"]').value) || 0;
    var pts = parseFloat(document.querySelector('input[name="nilai[' + siswaId + '][pts]"]').value) || 0;
    var pas = parseFloat(document.querySelector('input[name="nilai[' + siswaId + '][pas]"]').value) || 0;

    var pFilled   = document.querySelector('input[name="nilai[' + siswaId + '][pengetahuan]"]').value.trim() !== '';
    var kFilled   = document.querySelector('input[name="nilai[' + siswaId + '][keterampilan]"]').value.trim() !== '';
    var ptsFilled = document.querySelector('input[name="nilai[' + siswaId + '][pts]"]').value.trim() !== '';
    var pasFilled = document.querySelector('input[name="nilai[' + siswaId + '][pas]"]').value.trim() !== '';

    var naEl   = document.getElementById('na-' + siswaId);
    var deskEl = document.getElementById('desk-' + siswaId);

    if (!naEl || !deskEl) return;

    if (pFilled && kFilled && ptsFilled && pasFilled) {
        var na = (p + k + pts + pas) / 4;
        naEl.textContent = na.toFixed(2);
        naEl.style.color = na >= 75 ? '#1e8449' : '#c0392b';
        deskEl.value = getDeskripsi(na);
        deskEl.style.background = '#f0faf4';
        deskEl.style.borderColor = '#2ecc71';
    } else {
        naEl.textContent = '...';
        naEl.style.color = '#e67e22';
    }
}

// Hitung saat halaman load jika nilai sudah ada
window.onload = function() {
    @foreach($siswas as $siswa)
    hitungRow('{{ $siswa->id }}');
    @endforeach
};
</script>

@endsection