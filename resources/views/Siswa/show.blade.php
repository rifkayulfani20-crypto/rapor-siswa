@extends('layouts.app')

@section('content')
<div class="page-title">Data Siswa</div>

<div class="card" style="max-width:600px;margin:0 auto;">
    <div class="card-header">
        <span><i class="fa fa-user"></i> Detail Data Siswa</span>
        <a href="{{ route('siswa.index') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        {{-- Avatar --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div style="width:80px;height:80px;border-radius:50%;background:#dde4ea;display:inline-flex;align-items:center;justify-content:center;">
                <i class="fa fa-user" style="font-size:36px;color:#aab4be;"></i>
            </div>
        </div>

        {{-- Detail Table --}}
        <table style="width:100%;font-size:13px;border-collapse:collapse;">
            @php
                $rows = [
                    ['Nama Lengkap',        $siswa->nama],
                    ['Kelas',               $siswa->kelas->nama_kelas ?? '-'],
                    ['Jenis Kelamin',        $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['NIS',                 $siswa->nis],
                    ['NISN',                $siswa->nisn],
                    ['Tempat, Tanggal Lahir', ($siswa->tempat_lahir ?? '-') . ', ' . ($siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('j F Y') : '-')],
                    ['Agama',               $siswa->agama ?? '-'],
                    ['Alamat',              $siswa->alamat ?? '-'],
                    ['Telepon',             $siswa->telepon ?? '-'],
                    ['Jenis Pendaftaran',   $siswa->jenis_pendaftaran ?? '-'],
                    ['Diterima Pada',       $siswa->diterima_pada ? \Carbon\Carbon::parse($siswa->diterima_pada)->format('d-m-Y') : '-'],
                    ['Anak ke',             $siswa->anak_ke ?? '-'],
                    ['Nama Ayah',           $siswa->nama_ayah ?? '-'],
                    ['Pekerjaan Ayah',      $siswa->pekerjaan_ayah ?? '-'],
                    ['Nama Ibu',            $siswa->nama_ibu ?? '-'],
                    ['Pekerjaan Ibu',       $siswa->pekerjaan_ibu ?? '-'],
                    ['Nama Wali',           $siswa->nama_wali ?? '-'],
                    ['Pekerjaan Wali',      $siswa->pekerjaan_wali ?? '-'],
                    ['Status',              $siswa->status],
                ];
            @endphp

            @foreach($rows as $row)
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:9px 12px;font-weight:600;color:#2c3e50;width:45%;vertical-align:top;">
                    {{ $row[0] }}
                </td>
                <td style="padding:9px 4px;color:#2c3e50;width:5%;">:</td>
                <td style="padding:9px 12px;color:#555;vertical-align:top;">
                    @if($row[0] === 'Status')
                        <span class="badge {{ $siswa->status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($siswa->status) }}
                        </span>
                    @else
                        {{ $row[1] }}
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        {{-- Tombol --}}
        <div style="display:flex;gap:8px;margin-top:20px;justify-content:flex-end;">
            <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-primary">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('siswa.index') }}" class="btn btn-warning">
                <i class="fa fa-times"></i> Tutup
            </a>
        </div>

    </div>
</div>
@endsection