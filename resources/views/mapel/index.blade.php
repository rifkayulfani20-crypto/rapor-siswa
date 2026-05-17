@extends('layouts.app')
@section('title','Data Mapel')
@section('page-title','Data Mapel')
@section('content')

<div class="page-title">Data Mapel</div>

<div class="card">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <a href="{{ route('mapel.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Mapel
        </a>
        <a href="#" class="btn btn-info btn-sm" title="Info"
           style="border-radius:50%;width:32px;height:32px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
            <i class="fa fa-info"></i>
        </a>
    </div>

    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;border-top:0;flex-wrap:wrap;gap:8px;">
        <select id="perPage" class="form-control" style="width:70px;"
            onchange="window.location='{{ route('mapel.index') }}?per_page='+this.value">
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
                    <th>Nama Mapel</th>
                    <th>Singkatan</th>
                    <th>Kelompok</th>
                    <th>Tahun Pelajaran</th>
                    <th style="width:110px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mapels as $i => $mapel)
                <tr>
                    <td>{{ $mapels->firstItem() + $i }}</td>
                    <td>{{ $mapel->nama }}</td>
                    <td>{{ $mapel->kode ?? '-' }}</td>
                    <td>{{ $mapel->kelompok ?? 'A' }}</td>
                    <td>{{ $mapel->tahunPelajaran->nama ?? ($mapel->tapel->nama ?? '-') }}</td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <a href="#" class="btn btn-success btn-sm"
                               style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                               title="Detail">
                                <i class="fa fa-list"></i>
                            </a>
                            <a href="{{ route('mapel.edit', $mapel) }}" class="btn btn-primary btn-sm"
                               style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;"
                               title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('mapel.destroy', $mapel) }}" style="display:inline;"
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
                    <td colspan="6" class="text-center text-muted" style="padding:40px;">
                        Belum ada data mata pelajaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $mapels->appends(request()->query())->links() }}
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