<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, User, Nilai, Kehadiran, SikapSiswa, RiwayatKelas, TahunPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller {

    public function index(Request $request) {
        $perPage = $request->input('per_page', 15);
        $search  = $request->input('search');
        $kelas   = $request->input('kelas_id');
        $status  = $request->input('status');

        $siswas = Siswa::with('kelas')
            ->when($search, fn($q) => $q
                ->where('nama', 'like', "%$search%")
                ->orWhere('nis',  'like', "%$search%")
                ->orWhere('nisn', 'like', "%$search%")
            )
            ->when($kelas,  fn($q) => $q->where('kelas_id', $kelas))
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $kelasList = Kelas::orderBy('nama')->get();
        return view('admin.Siswa.index', compact('siswas', 'kelasList'));
    }

    public function create() {
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.Siswa.form', compact('kelas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|string|unique:siswas',
            'nisn'          => 'nullable|string|unique:siswas,nisn',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'nama_ayah'     => 'nullable|string',
            'nama_ibu'      => 'nullable|string',
            'nama_wali'     => 'nullable|string',
            'no_hp_ortu'    => 'nullable|numeric|digits_between:8,15',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        $siswa = Siswa::create([
            'user_id'       => $user->id,
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'nisn'          => $request->nisn ?: null,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'nama_ayah'     => $request->nama_ayah,
            'nama_ibu'      => $request->nama_ibu,
            'nama_wali'     => $request->nama_wali,
            'no_hp_ortu'    => $request->no_hp_ortu,
            'kelas_id'      => $request->kelas_id,
            'status'        => $request->status,
        ]);

        $this->catatRiwayatKelas($siswa, $request->kelas_id);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(Siswa $siswa) {
        $siswa->load('kelas');
        return view('admin.Siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa) {
        $siswa->load('user');
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.Siswa.form', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nis'           => 'required|string|unique:siswas,nis,'.$siswa->id,
            'nisn'          => 'nullable|string|unique:siswas,nisn,'.$siswa->id,
            'email'         => 'nullable|email|unique:users,email,'.($siswa->user_id ?? 0),
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'nama_ayah'     => 'nullable|string',
            'nama_ibu'      => 'nullable|string',
            'nama_wali'     => 'nullable|string',
            'no_hp_ortu'    => 'nullable|numeric|digits_between:8,15',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        if ($siswa->user_id) {
            $user = User::find($siswa->user_id);
            if ($user) {
                $user->update(['name' => $request->nama]);
                if ($request->filled('email')) {
                    $user->update(['email' => $request->email]);
                }
                if ($request->filled('password')) {
                    $user->update(['password' => Hash::make($request->password)]);
                }
            }
        }

        $siswa->update([
            'nama'          => $request->nama,
            'nis'           => $request->nis,
            'nisn'          => $request->nisn ?: null,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'nama_ayah'     => $request->nama_ayah,
            'nama_ibu'      => $request->nama_ibu,
            'nama_wali'     => $request->nama_wali,
            'no_hp_ortu'    => $request->no_hp_ortu,
            'kelas_id'      => $request->kelas_id,
            'status'        => $request->status,
        ]);

        $this->catatRiwayatKelas($siswa, $request->kelas_id);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy(Siswa $siswa) {
        Nilai::where('siswa_id', $siswa->id)->delete();
        Kehadiran::where('siswa_id', $siswa->id)->delete();
        SikapSiswa::where('siswa_id', $siswa->id)->delete();
        RiwayatKelas::where('siswa_id', $siswa->id)->delete();

        if ($siswa->user_id) {
            User::find($siswa->user_id)?->delete();
        }

        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }

    /**
     * Catat/perbarui riwayat kelas siswa untuk tahun pelajaran yang sedang aktif.
     * Ini memastikan histori kelas di tahun ajaran sebelumnya tidak ikut tertimpa
     * saat siswa dipindah/naik kelas di tahun ajaran berjalan.
     */
    private function catatRiwayatKelas(Siswa $siswa, $kelasId): void {
        if (!$kelasId) {
            return;
        }

        $tapel = TahunPelajaran::aktif();
        if (!$tapel) {
            return;
        }

        RiwayatKelas::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tahun_pelajaran_id' => $tapel->id],
            ['kelas_id' => $kelasId]
        );
    }
}