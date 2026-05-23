@extends('layouts.app')

@section('content')
<div class="page-title">Data Guru</div>

<div class="card" style="max-width:600px;margin:0 auto;">
    <div class="card-header">
        <span><i class="fa fa-user-tie"></i> Detail Data Guru</span>
        <a href="{{ route('guru.index') }}" class="btn btn-warning btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    <div class="card-body">

        {{-- Avatar --}}
        <div style="text-align:center;margin-bottom:24px;">
            <div style="width:80px;height:80px;border-radius:50%;background:#dde4ea;display:inline-flex;align-items:center;justify-content:center;">
                <i class="fa fa-user-tie" style="font-size:36px;color:#aab4be;"></i>
            </div>
            <div style="margin-top:8px;font-size:15px;font-weight:700;color:#2c3e50;">{{ $guru->nama }}</div>
            <div style="font-size:12px;color:#7f8c8d;">{{ $guru->jabatan ?? 'Guru' }}</div>
        </div>

        {{-- Detail Table --}}
        <table style="width:100%;font-size:13px;border-collapse:collapse;">
            @php
                $rows = [
                    ['Nama Lengkap',      $guru->nama],
                    ['Jenis Kelamin',     $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['NIP',              $guru->nip ?? '-'],
                    ['NUPTK',            $guru->nuptk ?? '-'],
                    ['Tempat, Tgl Lahir', ($guru->tempat_lahir ?? '-') . ', ' . ($guru->tanggal_lahir ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('j F Y') : '-')],
                    ['Agama',            $guru->agama ?? '-'],
                    ['Alamat',           $guru->alamat ?? '-'],
                    ['No. HP',           $guru->no_hp ?? '-'],
                    ['Email',            $guru->user->email ?? '-'],
                    ['Jabatan',          $guru->jabatan ?? '-'],
                    ['Pendidikan',       $guru->pendidikan ?? '-'],
                    ['Status',           $guru->status ?? 'Aktif'],
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
                        <span class="badge {{ ($guru->status ?? 'Aktif') === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($guru->status ?? 'AKTIF') }}
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
            <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-primary">
                <i class="fa fa-edit"></i> Edit
            </a>
            <a href="{{ route('guru.index') }}" class="btn btn-warning">
                <i class="fa fa-times"></i> Tutup
            </a>
        </div>

    </div>
</div>
@endsection