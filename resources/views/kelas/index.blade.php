@extends('layouts.app')
@section('title','Data Kelas')
@section('page-title','Data Kelas')
@section('content')

<div class="page-title">Data Kelas</div>

<div class="card">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">

        <a href="{{ route('kelas.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Kelas
        </a>

        <div style="display:flex;align-items:center;gap:8px;">
            <a href="#" class="btn btn-info btn-sm" title="Info"
               style="border-radius:50%;width:32px;height:32px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
                <i class="fa fa-info"></i>
            </a>
        </div>

    </div>

    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;border-top:0;">

        <select id="perPage" class="form-control" style="width:70px;"
            onchange="window.location='{{ route('kelas.index') }}?per_page='+this.value">
            @foreach([10,25,50,100] as $n)
                <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }}</option>
            @endforeach
        </select>

        <input type="text" id="cari" placeholder="Search..."
               class="form-control" style="width:200px;">

    </div>

    <div class="card-body" style="padding:0;">
        <table class="table table-bordered table-hover mb-0" id="tbl">
            <thead style="background:#343a40;color:#fff;">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Tahun Pelajaran</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelas as $i => $k)
                <tr>
                    <td>{{ $kelas->firstItem() + $i }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->waliKelas->nama ?? '-' }}</td>
                    <td>{{ $k->tahunPelajaran->nama ?? '-' }}</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <a href="#" class="btn btn-success btn-sm"
                               style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                               title="Detail">
                                <i class="fa fa-list"></i>
                            </a>
                            <a href="{{ route('kelas.edit', $k) }}" class="btn btn-primary btn-sm"
                               style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                               title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('kelas.destroy', $k) }}" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                                        title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted" style="padding:40px;">
                        Belum ada data kelas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $kelas->appends(request()->query())->links() }}
    </div>
</div>

<script>
document.getElementById('cari').addEventListener('keyup', function () {
    const v = this.value.toLowerCase();
    document.querySelectorAll('#tbl tbody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(v) ? '' : 'none';
    });
});
</script>

@endsection