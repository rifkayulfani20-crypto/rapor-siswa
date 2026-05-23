@extends('layouts.app')
@section('title', 'Edit Data Akun')
@section('page-title', 'Data Akun')

@section('content')
<div class="page-title">Data Akun</div>

<div class="card" style="max-width:680px">
    <div class="card-header-bar">
        <span class="title">Edit Data Akun</span>
    </div>
    <div class="card-body" style="padding:28px">
        <form action="{{ route('akun.update', $akun->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control" value="{{ $akun->name }}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                       value="{{ old('username', $akun->username) }}" required>
                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Email <span class="text-muted fw-normal">(Opsional)</span></label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $akun->email) }}">
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label">Password <span class="text-muted fw-normal">(opsional)</span></label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="Masukkan password baru">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="konfirmasi" id="konfirmasi" value="1" required>
                    <label class="form-check-label" for="konfirmasi" style="font-size:13px">
                        Saya yakin akan mengubah data tersebut
                    </label>
                </div>
            </div>
            <button type="submit" class="btn btn-success" style="padding:9px 24px">Simpan</button>
            <a href="{{ route('akun.index') }}" class="btn btn-secondary ms-2" style="padding:9px 20px">Batal</a>
        </form>
    </div>
</div>
@endsection