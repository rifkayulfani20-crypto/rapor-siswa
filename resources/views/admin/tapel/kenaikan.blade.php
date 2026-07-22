@extends('layouts.app')

@section('content')
<div class="page-title">Kenaikan Kelas</div>

<div class="card" style="margin-bottom:16px;">
    <div class="card-body">
        <p style="font-size:13px;color:#666;line-height:1.6;">
            Menaikkan seluruh siswa aktif dari <strong>{{ $tapel->nama }} ({{ $tapel->semester }})</strong>
            ke tahun pelajaran tujuan. Kelas tingkat 7 &rarr; 8, tingkat 8 &rarr; 9, dan siswa
            tingkat 9 akan otomatis diluluskan (status berubah jadi <strong>Lulus</strong>, tidak masuk kelas manapun).
        </p>
    </div>
</div>

@if($tapelTujuanOptions->isEmpty())
    <div class="card">
        <div class="card-body">
            <p style="font-size:13px;color:#c0392b;">
                Belum ada Tahun Pelajaran lain untuk dijadikan tujuan. Silakan
                <a href="{{ route('tapel.create') }}" style="color:#1a3a6c;text-decoration:underline;">buat Tahun Pelajaran baru</a> terlebih dahulu
                (biarkan tidak aktif dulu), baru kembali ke sini.
            </p>
        </div>
    </div>
@else
<form method="POST" action="{{ route('tapel.kenaikan.process', $tapel->id) }}"
      onsubmit="return confirm('Yakin mau jalankan kenaikan kelas? Proses ini memindahkan siswa secara massal.');">
    @csrf

    <div class="card" style="margin-bottom:16px;">
        <div class="card-header"><span style="font-weight:600;">Tahun Pelajaran Tujuan</span></div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Pindahkan ke <span style="color:#e74c3c;">*</span></label>
                    <select name="tapel_tujuan_id" required
                        class="form-control {{ $errors->has('tapel_tujuan_id') ? 'is-invalid' : '' }}">
                        <option value="">-- Pilih Tahun Pelajaran --</option>
                        @foreach($tapelTujuanOptions as $opt)
                            <option value="{{ $opt->id }}" {{ old('tapel_tujuan_id') == $opt->id ? 'selected' : '' }}>
                                {{ $opt->nama }} ({{ $opt->semester }})
                            </option>
                        @endforeach
                    </select>
                    @error('tapel_tujuan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-group" style="margin-bottom:0;display:flex;align-items:flex-end;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;color:#444;font-weight:500;">
                        <input type="checkbox" name="aktifkan_tujuan" value="1" style="width:16px;height:16px;">
                        Aktifkan tahun pelajaran tujuan setelah proses ini selesai
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><span style="font-weight:600;">Pemetaan Kelas</span></div>
        <div class="card-body">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Kelas Asal</th>
                            <th width="90">Tingkat</th>
                            <th width="120">Jumlah Siswa Aktif</th>
                            <th>Nama Kelas Baru</th>
                            <th>Wali Kelas Baru</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($kelasList as $kelas)
                        <tr>
                            <td>{{ $kelas->nama }}</td>
                            <td>
                                @if($kelas->tingkat_tujuan)
                                    {{ $kelas->tingkat }} &rarr; {{ $kelas->tingkat_tujuan }}
                                @else
                                    {{ $kelas->tingkat }} &rarr; <span style="color:#1e8449;font-weight:600;">Lulus</span>
                                @endif
                            </td>
                            <td>{{ $kelas->siswas_count }}</td>
                            <td>
                                @if($kelas->tingkat_tujuan)
                                    <input type="text" name="mapping[{{ $kelas->id }}][nama]"
                                        value="{{ old("mapping.{$kelas->id}.nama", $kelas->nama_saran) }}"
                                        class="form-control" style="padding:6px 10px;">
                                @else
                                    <span style="color:#aaa;font-size:12px;">Siswa akan diluluskan, tidak perlu kelas baru</span>
                                @endif
                            </td>
                            <td>
                                @if($kelas->tingkat_tujuan)
                                    <select name="mapping[{{ $kelas->id }}][wali_kelas_id]"
                                        class="form-control" style="padding:6px 10px;">
                                        <option value="">-- Tanpa Wali Kelas --</option>
                                        @foreach($gurus as $guru)
                                            <option value="{{ $guru->id }}" {{ $kelas->wali_kelas_id == $guru->id ? 'selected' : '' }}>
                                                {{ $guru->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <span style="color:#aaa;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;color:#7f8c8d;padding:20px">
                                Tidak ada kelas di tahun pelajaran ini.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="display:flex;gap:8px;margin-top:20px;">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-arrow-up"></i> Proses Kenaikan Kelas
        </button>
        <a href="{{ route('tapel.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Batal
        </a>
    </div>
</form>
@endif
@endsection