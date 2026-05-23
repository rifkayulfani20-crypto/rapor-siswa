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
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][keterampilan]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.keterampilan', $nilai->nilai_keterampilan ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][pts]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.pts', $nilai->nilai_pts ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100">
                            </td>
                            <td>
                                <input type="number" name="nilai[{{ $siswa->id }}][pas]" min="0" max="100"
                                       value="{{ old('nilai.'.$siswa->id.'.pas', $nilai->nilai_pas ?? '') }}"
                                       class="form-control" style="text-align:center;font-size:13px;" placeholder="0-100">
                            </td>
                            <td>
                                <textarea name="nilai[{{ $siswa->id }}][deskripsi]" class="form-control" rows="2"
                                    style="font-size:12px;resize:vertical;"
                                    placeholder="Deskripsi nilai...">{{ old('nilai.'.$siswa->id.'.deskripsi', $nilai->deskripsi ?? '') }}</textarea>
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

@endsection