@extends('layouts.app')
@section('content')
<h1 class="page-title">{{ isset($tapel) ? 'Edit' : 'Tambah' }} Tahun Pelajaran</h1>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($tapel) ? route('tapel.update', $tapel) : route('tapel.store') }}">
            @csrf @if(isset($tapel)) @method('PUT') @endif
            <div class="form-group">
                <label class="form-label">Nama Tahun Pelajaran *</label>
                <input type="text" name="nama" class="form-control" placeholder="Contoh: 2023/2024" value="{{ old('nama', $tapel->nama ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Semester *</label>
                <select name="semester" class="form-control" required>
                    <option value="Ganjil" {{ old('semester', $tapel->semester ?? '') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                    <option value="Genap" {{ old('semester', $tapel->semester ?? '') == 'Genap' ? 'selected' : '' }}>Genap</option>
                </select>
            </div>
            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $tapel->aktif ?? false) ? 'checked' : '' }}>
                    <span class="form-label" style="margin:0;">Jadikan Aktif</span>
                </label>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <a href="{{ route('tapel.index') }}" class="btn btn-danger"><i class="fa fa-times"></i> Batal</a>
        </form>
    </div>
</div>
@endsection