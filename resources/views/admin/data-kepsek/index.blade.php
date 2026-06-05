@extends('layouts.app')

@section('content')
<div class="page-title">Data Kepala Sekolah</div>

@if(session('success'))
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <span class="font-semibold">Daftar Akun Kepala Sekolah</span>
        <a href="{{ route('kepsek-user.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Tambah Kepsek
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;text-align:center;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kepseks as $i => $kepsek)
                    <tr>
                        <td style="text-align:center;">{{ $kepseks->firstItem() + $i }}</td>
                        <td>{{ $kepsek->name }}</td>
                        <td>{{ $kepsek->email }}</td>
                        <td style="text-align:center;">
                            <a href="{{ route('kepsek-user.edit', $kepsek) }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('kepsek-user.destroy', $kepsek) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('Hapus akun {{ $kepsek->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:24px;color:#aaa;">
                            Belum ada akun Kepala Sekolah
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $kepseks->links() }}</div>
    </div>
</div>
@endsection