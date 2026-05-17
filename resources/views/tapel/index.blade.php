@extends('layouts.app')
@section('content')
<h1 class="page-title">Data Tahun Pelajaran</h1>
<div class="card">
    <div class="card-body">
        <div class="table-toolbar">
            <a href="{{ route('tapel.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tahun Pelajaran</a>
        </div>
        <div class="table-wrapper">
            <table>
                <thead><tr><th>#</th><th>Nama</th><th>Semester</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($tapels as $i => $tapel)
                <tr>
                    <td>{{ $tapels->firstItem() + $i }}</td>
                    <td>{{ $tapel->nama }}</td>
                    <td>{{ $tapel->semester }}</td>
                    <td><span class="badge {{ $tapel->aktif ? 'badge-success' : 'badge-warning' }}">{{ $tapel->aktif ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    <td>
                        <a href="{{ route('tapel.edit', $tapel) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                        <form method="POST" action="{{ route('tapel.destroy', $tapel) }}" style="display:inline;" onsubmit="return confirm('Hapus?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:30px;color:#7f8c8d;">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $tapels->links() }}</div>
    </div>
</div>
@endsection