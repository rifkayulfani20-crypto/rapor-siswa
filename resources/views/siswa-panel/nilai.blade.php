@extends('layouts.siswa')
@section('content')

<h1 class="page-title">Nilai Akhir</h1>

<div class="card">
    <div class="card-header">
        <i class="fa fa-star"></i> Daftar Nilai &mdash; {{ $siswa->nama }} | Kelas {{ $siswa->kelas?->nama }} | {{ $tapel?->nama }}
    </div>
    <div class="card-body" style="padding:0">
        @if($nilais->count())
        <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mata Pelajaran</th>
                    <th style="text-align:center">Pengetahuan</th>
                    <th style="text-align:center">Keterampilan</th>
                    <th style="text-align:center">PTS</th>
                    <th style="text-align:center">PAS</th>
                    <th style="text-align:center">Nilai Akhir</th>
                    <th style="text-align:center">Predikat</th>
                    <th style="text-align:center">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nilais as $i => $n)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $n->mataPelajaran?->nama }}</td>
                    <td style="text-align:center">{{ $n->nilai_pengetahuan ?? '-' }}</td>
                    <td style="text-align:center">{{ $n->nilai_keterampilan ?? '-' }}</td>
                    <td style="text-align:center">{{ $n->nilai_pts ?? '-' }}</td>
                    <td style="text-align:center">{{ $n->nilai_pas ?? '-' }}</td>
                    <td style="text-align:center;font-weight:700">{{ $n->nilai_akhir ?? '-' }}</td>
                    <td style="text-align:center">
                        @php $p = $n->getPredikat(); @endphp
                        <span class="badge {{ $p=='A'?'badge-success':($p=='B'?'badge-primary':($p=='C'?'badge-warning':'badge-danger')) }}">
                            {{ $p }}
                        </span>
                    </td>
                    <td style="text-align:center">
                        @if(($n->nilai_akhir ?? 0) >= ($n->mataPelajaran?->kkm ?? 75))
                            <span class="badge badge-success">Tuntas</span>
                        @else
                            <span class="badge badge-danger">Belum Tuntas</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background:#f8f9fa;font-weight:700">
                    <td colspan="6" style="padding:10px 12px;text-align:right">Rata-rata Nilai Akhir:</td>
                    <td style="text-align:center;padding:10px 12px">{{ round($nilais->avg('nilai_akhir'),1) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
        </div>
        @else
        <div style="text-align:center;padding:40px;color:#7f8c8d">
            <i class="fa fa-inbox" style="font-size:40px;margin-bottom:10px"></i>
            <p>Belum ada nilai yang diinput.</p>
        </div>
        @endif
    </div>
</div>

@endsection
