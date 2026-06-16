@extends('layouts.siswa')
@section('content')

<div class="page-title">Profil Saya</div>

<div style="max-width:600px;">

    {{-- Avatar Card --}}
    <div class="card mb-3" style="border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(26,58,108,0.15); border:none;">
        <div style="background:linear-gradient(135deg,#1a3a6c 0%,#122a52 100%); padding:24px 28px; display:flex; align-items:center; gap:20px; position:relative; overflow:hidden;">
            <div style="position:absolute;top:-30px;right:-30px;width:120px;height:120px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-40px;left:80px;width:150px;height:150px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

            <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,0.15);border:3px solid rgba(255,255,255,0.4);display:flex;align-items:center;justify-content:center;color:white;font-size:28px;font-weight:bold;flex-shrink:0;position:relative;z-index:1;">
                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            </div>

            <div style="position:relative;z-index:1;">
                <div style="font-size:20px;font-weight:700;color:#fff;margin-bottom:6px;">
                    {{ $siswa->nama }}
                </div>
                <span style="display:inline-block;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;background:rgba(255,255,255,0.15);color:#fff;border:1px solid rgba(255,255,255,0.25);margin-bottom:6px;">
                    <i class="fa fa-user-graduate" style="margin-right:4px;"></i> Siswa
                </span>
                <div style="font-size:12px;color:rgba(255,255,255,0.7);display:flex;align-items:center;gap:6px;">
                    <i class="fa fa-id-card"></i> NIS: {{ $siswa->nis }}
                </div>
            </div>
        </div>
    </div>

    {{-- Data Diri Card --}}
    <div class="card" style="border-radius:12px;border:none;box-shadow:0 4px 20px rgba(26,58,108,0.12);overflow:hidden;margin-bottom:20px;">
        <div class="card-header" style="background:linear-gradient(90deg,#1a3a6c,#122a52);border:none;padding:14px 22px;">
            <div style="font-weight:600;color:#fff;font-size:14px;display:flex;align-items:center;gap:8px;">
                <i class="fa fa-user"></i> Data Diri
            </div>
        </div>
        <div class="card-body" style="padding:20px 24px;">
            @php
            $rows = [
                'Nama Lengkap'      => $siswa->nama,
                'NIS'               => $siswa->nis,
                'NISN'              => $siswa->nisn,
                'Jenis Kelamin'     => $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
                'Tempat Lahir'      => $siswa->tempat_lahir ?? '-',
                'Tanggal Lahir'     => $siswa->tanggal_lahir?->format('d F Y') ?? '-',
                'Kelas'             => $siswa->kelas?->nama ?? '-',
                'Alamat'            => $siswa->alamat ?? '-',
                'Nama Ayah'         => $siswa->nama_ayah ?? '-',
                'Nama Ibu'          => $siswa->nama_ibu ?? '-',
                'No. HP Orang Tua'  => $siswa->no_hp_ortu ?? '-',
                'Status'            => $siswa->status,
            ];
            @endphp
            @foreach($rows as $label => $val)
            <div style="display:flex;padding:9px 0;border-bottom:1px solid #f0f0f0;font-size:13px">
                <span style="width:160px;color:#7f8c8d;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:0.5px;padding-top:2px;">{{ $label }}</span>
                <span style="color:#2c3e50;font-weight:500;">{{ $val }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Ganti Password Card --}}
    <div class="card" style="border-radius:12px;border:none;box-shadow:0 4px 20px rgba(26,58,108,0.12);overflow:hidden;">
        <div class="card-header" style="background:linear-gradient(90deg,#1a3a6c,#122a52);border:none;padding:14px 22px;">
            <div style="font-weight:600;color:#fff;font-size:14px;display:flex;align-items:center;gap:8px;">
                <i class="fa fa-lock"></i> Ganti Password
            </div>
        </div>
        <div class="card-body" style="padding:20px 24px;">

            @if(session('password_success'))
                <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('password_success') }}</div>
            @endif
            @if(session('password_error'))
                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> {{ session('password_error') }}</div>
            @endif

            <form method="POST" action="{{ route('siswa.profil.password') }}">
                @csrf
                @method('PUT')

                <div style="margin-bottom:14px;">
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Password Lama <span style="color:red;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa fa-lock" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:12px;"></i>
                        <input type="password" name="password_lama" id="pw1" required
                            placeholder="Masukkan password lama"
                            style="width:100%;padding:8px 34px 8px 32px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                        <span onclick="togglePw('pw1','ic1')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#aaa;">
                            <i class="fa fa-eye" id="ic1"></i>
                        </span>
                    </div>
                    @error('password_lama')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:14px;">
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Password Baru <span style="color:red;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa fa-lock" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:12px;"></i>
                        <input type="password" name="password_baru" id="pw2" required
                            placeholder="Min. 6 karakter"
                            style="width:100%;padding:8px 34px 8px 32px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                        <span onclick="togglePw('pw2','ic2')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#aaa;">
                            <i class="fa fa-eye" id="ic2"></i>
                        </span>
                    </div>
                    @error('password_baru')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom:20px;">
                    <label style="font-size:12px;font-weight:600;color:#2c3e50;display:block;margin-bottom:5px;">Konfirmasi Password Baru <span style="color:red;">*</span></label>
                    <div style="position:relative;">
                        <i class="fa fa-lock" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#aaa;font-size:12px;"></i>
                        <input type="password" name="password_baru_confirmation" id="pw3" required
                            placeholder="Ulangi password baru"
                            style="width:100%;padding:8px 34px 8px 32px;border:1px solid #ddd;border-radius:6px;font-size:13px;outline:none;box-sizing:border-box;">
                        <span onclick="togglePw('pw3','ic3')" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);cursor:pointer;color:#aaa;">
                            <i class="fa fa-eye" id="ic3"></i>
                        </span>
                    </div>
                    @error('password_baru_confirmation')<p style="color:red;font-size:11px;margin-top:3px;">{{ $message }}</p>@enderror
                </div>

                <button type="submit" style="background:#1a3a6c;color:#fff;border:none;padding:10px 24px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:7px;">
                    <i class="fa fa-save"></i> Simpan Password
                </button>
            </form>
        </div>
    </div>

</div>

@push('scripts')
<script>
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fa fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fa fa-eye';
    }
}
</script>
@endpush
@endsection