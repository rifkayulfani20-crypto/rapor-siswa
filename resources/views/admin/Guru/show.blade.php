@extends('layouts.app')

@section('content')
<div class="page-title">Detail Guru</div>

<div style="max-width:720px;">
    <div class="card">
        <div class="card-header">
            <span class="font-semibold text-gray-700" style="font-size:14px;">
                <i class="fa fa-user-tie mr-1"></i> {{ $guru->nama }}
            </span>
            <div style="display:flex;gap:6px;">
                <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-edit"></i> Edit
                </a>
                <a href="{{ route('guru.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <div class="card-body" style="padding:16px 20px;">

            {{-- DATA PRIBADI --}}
            <div style="font-size:11px;font-weight:600;color:#95a5a6;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">
                Data Pribadi
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;margin-bottom:16px;">

                @php
                $fields = [
                    ['label' => 'Nama Lengkap',      'value' => $guru->nama],
                    ['label' => 'Jenis Kelamin',      'value' => $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'],
                    ['label' => 'NIP',                'value' => $guru->nip ?? '-'],
                    ['label' => 'NUPTK',              'value' => $guru->nuptk ?? '-'],
                    ['label' => 'Tempat Lahir',       'value' => $guru->tempat_lahir ?? '-'],
                    ['label' => 'Tanggal Lahir',      'value' => $guru->tanggal_lahir
                        ? \Carbon\Carbon::parse($guru->tanggal_lahir)->translatedFormat('j F Y')
                        : '-'],
                    ['label' => 'No. HP',             'value' => $guru->no_hp ?? '-'],
                    ['label' => 'Email',              'value' => $guru->user->email ?? '-'],
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
                    <div style="font-size:13px;font-weight:500;color:#2c3e50;">{{ $guru->alamat ?? '-' }}</div>
                </div>

            </div>

            <div style="border-top:1px solid #f0f0f0;margin-bottom:14px;"></div>

            {{-- AKUN --}}
            <div style="font-size:11px;font-weight:600;color:#95a5a6;letter-spacing:.08em;text-transform:uppercase;margin-bottom:8px;">
                Info Akun
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px 20px;">
                <div>
                    <div style="font-size:11px;color:#95a5a6;margin-bottom:2px;">Role</div>
                    <div style="font-size:13px;font-weight:500;color:#2c3e50;">{{ ucfirst($guru->user->role ?? '-') }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:#95a5a6;margin-bottom:2px;">Status</div>
                    <div>
                        <span class="badge {{ ($guru->status ?? 'Aktif') === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                            {{ strtoupper($guru->status ?? 'AKTIF') }}
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection