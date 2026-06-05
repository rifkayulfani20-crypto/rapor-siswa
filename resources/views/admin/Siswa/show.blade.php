@extends('layouts.app')

@section('content')
<div class="page-title">Detail Siswa</div>

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header">
            <span class="font-semibold text-gray-700" style="font-size:14px;">
                <i class="fa fa-id-card mr-1"></i> {{ $siswa->nama }}
            </span>
            <div style="display:flex;gap:6px;">
                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('siswa.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body" style="padding:16px 20px;">

            {{-- STATUS BADGE --}}
            <div style="margin-bottom:14px;">
                <span class="badge {{ $siswa->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                    {{ strtoupper($siswa->status) }}
                </span>
                <span style="font-size:12px;color:#7f8c8d;margin-left:6px;">
                    {{ $siswa->kelas->nama ?? 'Belum ada kelas' }}
                </span>
            </div>

            {{-- DATA PRIBADI --}}
            <div style="font-size:11px;font-weight:600;color:#95a5a6;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">
                Data Pribadi
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;margin-bottom:16px;">

                @php
                $fields = [
                    ['label' => 'Nama Lengkap', 'value' => $siswa->nama],
                    ['label' => 'NIS',           'value' => $siswa->nis],
                    ['label' => 'NISN',          'value' => $siswa->nisn ?? '-'],
                    ['label' => 'Jenis Kelamin', 'value' => $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['label' => 'Tempat Lahir',  'value' => $siswa->tempat_lahir ?? '-'],
                    ['label' => 'Tanggal Lahir', 'value' => $siswa->tanggal_lahir
                        ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('j F Y')
                        : '-'],
                ];
                @endphp

                @foreach($fields as $f)
                <div>
                    <div style="font-size:11px;color:#95a5a6;margin-bottom:2px;">{{ $f['label'] }}</div>
                    <div style="font-size:13px;font-weight:500;color:#2c3e50;">{{ $f['value'] }}</div>
                </div>
                @endforeach

                <div style="grid-column:span 2;">
                    <div style="font-size:11px;color:#95a5a6;margin-bottom:2px;">Alamat</div>
                    <div style="font-size:13px;font-weight:500;color:#2c3e50;">{{ $siswa->alamat ?? '-' }}</div>
                </div>
            </div>

            <div style="border-top:1px solid #f0f0f0;margin-bottom:14px;"></div>

            {{-- DATA ORANG TUA --}}
            <div style="font-size:11px;font-weight:600;color:#95a5a6;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">
                Orang Tua / Wali
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;">

                @php
                $ortu = [
                    ['label' => 'Nama Ayah',       'value' => $siswa->nama_ayah ?? '-'],
                    ['label' => 'Nama Ibu',        'value' => $siswa->nama_ibu ?? '-'],
                    ['label' => 'Nama Wali',       'value' => $siswa->nama_wali ?? '-'],
                    ['label' => 'No. HP Orang Tua','value' => $siswa->no_hp_ortu ?? '-'],
                ];
                @endphp

                @foreach($ortu as $f)
                <div>
                    <div style="font-size:11px;color:#95a5a6;margin-bottom:2px;">{{ $f['label'] }}</div>
                    <div style="font-size:13px;font-weight:500;color:#2c3e50;">{{ $f['value'] }}</div>
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>
@endsection