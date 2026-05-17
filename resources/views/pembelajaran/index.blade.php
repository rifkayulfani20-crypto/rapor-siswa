@extends('layouts.app')
@section('title','Data Pembelajaran')
@section('page-title','Data Pembelajaran')
@section('content')

<div class="page-title">Data Pembelajaran</div>

<div class="card">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
        <a href="{{ route('pembelajaran.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Pembelajaran
        </a>
        <a href="#" class="btn btn-info btn-sm" title="Info"
           style="border-radius:50%;width:32px;height:32px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
            <i class="fa fa-info"></i>
        </a>
    </div>

    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;border-top:0;flex-wrap:wrap;gap:8px;">
        <select id="perPage" class="form-control" style="width:70px;"
            onchange="window.location='{{ route('pembelajaran.index') }}?per_page='+this.value">
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
                    <th>Guru</th>
                    <th>Mata Pelajaran</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th style="width:80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembelajaran as $i => $p)
                <tr>
                    <td>{{ $pembelajaran->firstItem() + $i }}</td>
                    <td>{{ $p->guru->nama ?? '-' }}</td>
                    <td>{{ $p->mataPelajaran->nama ?? '-' }}</td>
                    <td>{{ $p->kelas->nama ?? '-' }}</td>
                    <td>
                        @if($p->status === 'Aktif')
                            <span style="padding:2px 10px;border-radius:4px;font-size:12px;font-weight:600;background:#d1fae5;color:#065f46;">
                                Aktif
                            </span>
                        @else
                            <span style="padding:2px 10px;border-radius:4px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e;">
                                {{ $p->status }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:4px;">
                            <a href="{{ route('pembelajaran.edit', $p) }}" class="btn btn-primary btn-sm"
                               style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('pembelajaran.destroy', $p) }}" style="display:inline;"
                                  onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                        style="width:30px;height:30px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding:40px;">
                        Belum ada data pembelajaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $pembelajaran->appends(request()->query())->links() }}
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