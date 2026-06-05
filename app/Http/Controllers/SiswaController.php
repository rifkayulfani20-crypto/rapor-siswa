<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, User, Nilai, Kehadiran, SikapSiswa};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller {

    // ─── INDEX + SEARCH SERVER-SIDE ────────────────────────────────────────
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

    // ─── CREATE ─────────────────────────────────────────────────────────────
    public function create() {
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.Siswa.form', compact('kelas'));
    }

    // ─── STORE ──────────────────────────────────────────────────────────────
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
            'no_hp_ortu'    => 'nullable|string',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'siswa',
        ]);

        Siswa::create([
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

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    // ─── SHOW ────────────────────────────────────────────────────────────────
    public function show(Siswa $siswa) {
        $siswa->load('kelas');
        return view('admin.Siswa.show', compact('siswa'));
    }

    // ─── EDIT ────────────────────────────────────────────────────────────────
    public function edit(Siswa $siswa) {
        $kelas = Kelas::orderBy('nama')->get();
        return view('admin.Siswa.form', compact('siswa', 'kelas'));
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────
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
            'no_hp_ortu'    => 'nullable|string',
            'kelas_id'      => 'nullable|exists:kelas,id',
            'status'        => 'required|in:Aktif,Nonaktif',
        ]);

        if ($siswa->user_id) {
            $siswa->user->update(['name' => $request->nama]);
            if ($request->filled('email')) {
                $siswa->user->update(['email' => $request->email]);
            }
            if ($request->filled('password')) {
                $siswa->user->update(['password' => Hash::make($request->password)]);
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

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // ─── DESTROY (hapus nilai, kehadiran, sikap dulu) ────────────────────────
    public function destroy(Siswa $siswa) {
        // Hapus data relasi dulu agar tidak terjadi foreign key error
        Nilai::where('siswa_id', $siswa->id)->delete();
        Kehadiran::where('siswa_id', $siswa->id)->delete();
        SikapSiswa::where('siswa_id', $siswa->id)->delete();

        // Hapus akun user terkait
        if ($siswa->user_id) {
            User::find($siswa->user_id)?->delete();
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa beserta nilai dan kehadiran berhasil dihapus!');
    }
}