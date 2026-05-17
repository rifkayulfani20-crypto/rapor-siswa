@extends('layouts.app')
@section('title','Data Akun')
@section('page-title','Data Akun')
@section('content')

<div class="page-title">Data Akun</div>

<div class="card">
    <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">

        <select id="perPage" class="form-control" style="width:70px;"
            onchange="window.location='{{ route('admin.akun.index') }}?per_page='+this.value">
            @foreach([10,25,50,100] as $n)
                <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }}</option>
            @endforeach
        </select>

        <div style="display:flex;align-items:center;gap:8px;">
            <input type="text" id="cari" placeholder="Search..."
                   class="form-control" style="width:200px;">
            <a href="#" class="btn btn-info btn-sm" title="Info" style="border-radius:50%;width:32px;height:32px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
                <i class="fa fa-info"></i>
            </a>
        </div>

    </div>

    <div class="card-body" style="padding:0;">
        <table class="table table-bordered table-hover mb-0" id="tbl">
            <thead style="background:#343a40;color:#fff;">
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Pemilik Akun</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width:60px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($akuns as $i => $akun)
                @php
                    $bg    = $akun->role==='admin'     ? '#fde8e8'
                           : ($akun->role==='guru'     ? '#e8f0fe'
                           : ($akun->role==='siswa'    ? '#e8f5e9'
                           :                            '#f3f4f6'));
                    $color = $akun->role==='admin'     ? '#c0392b'
                           : ($akun->role==='guru'     ? '#1a56db'
                           : ($akun->role==='siswa'    ? '#276749'
                           :                            '#6b7280'));
                @endphp
                <tr>
                    <td>{{ $akuns->firstItem() + $i }}</td>
                    <td>{{ $akun->name }}</td>
                    <td>{{ $akun->username ?? '-' }}</td>
                    <td>{{ $akun->email ?? '-' }}</td>
                    <td>
                        <span style="padding:2px 10px;border-radius:4px;font-size:12px;font-weight:600;background:{{ $bg }};color:{{ $color }};">
                            {{ $akun->role }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.akun.edit', $akun) }}"
                           class="btn btn-primary btn-sm"
                           style="width:32px;height:32px;padding:0;display:inline-flex;align-items:center;justify-content:center;">
                            <i class="fa fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding:40px;">
                        Belum ada data akun
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $akuns->appends(request()->query())->links() }}
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