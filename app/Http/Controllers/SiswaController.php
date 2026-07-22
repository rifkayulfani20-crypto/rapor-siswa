<?php
namespace App\Http\Controllers;
use App\Models\{Siswa, Kelas, User, Nilai, Kehadiran, SikapSiswa, RiwayatKelas, TahunPelajaran};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
     * Unduh template CSV untuk import siswa massal.
     */
    public function downloadTemplate() {
        $columns = ['nama','nis','nisn','email','password','jenis_kelamin','tempat_lahir','tanggal_lahir','alamat','nama_ayah','nama_ibu','nama_wali','no_hp_ortu','kelas','status'];
        $contoh  = ['Ahmad Fauzi','2024001','0051234567','ahmad@sekolah.sch.id','','L','Jakarta','2010-05-12','Jl. Merdeka No. 1','Budi Santoso','Siti Aminah','','081234567890','7A','Aktif'];

        return response()->streamDownload(function () use ($columns, $contoh) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fputcsv($out, $contoh);
            fclose($out);
        }, 'template_import_siswa.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * Import siswa secara massal dari file CSV.
     * Kolom 'password' boleh dikosongkan → default memakai NIS.
     * Kolom 'kelas' berisi nama kelas (contoh: 7A), akan dicocokkan ke tabel kelas.
     */
    public function import(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = array_map(fn($h) => strtolower(trim($h)), fgetcsv($handle));

        $success = 0;
        $failed  = [];
        $rowNum  = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (count(array_filter($row, fn($v) => trim((string) $v) !== '')) === 0) {
                continue; // lewati baris kosong
            }

            $data = array_combine($header, array_pad($row, count($header), null));

            $validator = Validator::make($data, [
                'nama'          => 'required|string|max:255',
                'nis'           => 'required|string|unique:siswas,nis',
                'nisn'          => 'nullable|string|unique:siswas,nisn',
                'email'         => 'required|email|unique:users,email',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_lahir' => 'nullable|date',
                'no_hp_ortu'    => 'nullable|numeric|digits_between:8,15',
                'status'        => 'nullable|in:Aktif,Nonaktif',
            ]);

            if ($validator->fails()) {
                $failed[] = "Baris $rowNum: " . implode(', ', $validator->errors()->all());
                continue;
            }

            try {
                $kelasId = null;
                if (!empty($data['kelas'])) {
                    $kelasId = Kelas::where('nama', trim($data['kelas']))->value('id');
                    if (!$kelasId) {
                        $failed[] = "Baris $rowNum: kelas '{$data['kelas']}' tidak ditemukan, siswa tetap disimpan tanpa kelas.";
                    }
                }

                $password = !empty($data['password']) ? $data['password'] : $data['nis'];

                $user = User::create([
                    'name'     => $data['nama'],
                    'email'    => $data['email'],
                    'password' => Hash::make($password),
                    'role'     => 'siswa',
                ]);

                $siswa = Siswa::create([
                    'user_id'       => $user->id,
                    'nama'          => $data['nama'],
                    'nis'           => $data['nis'],
                    'nisn'          => $data['nisn'] ?: null,
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tempat_lahir'  => $data['tempat_lahir'] ?: null,
                    'tanggal_lahir' => $data['tanggal_lahir'] ?: null,
                    'alamat'        => $data['alamat'] ?: null,
                    'nama_ayah'     => $data['nama_ayah'] ?: null,
                    'nama_ibu'      => $data['nama_ibu'] ?: null,
                    'nama_wali'     => $data['nama_wali'] ?: null,
                    'no_hp_ortu'    => $data['no_hp_ortu'] ?: null,
                    'kelas_id'      => $kelasId,
                    'status'        => $data['status'] ?: 'Aktif',
                ]);

                $this->catatRiwayatKelas($siswa, $kelasId);
                $success++;
            } catch (\Throwable $e) {
                $failed[] = "Baris $rowNum: gagal disimpan ({$e->getMessage()})";
            }
        }

        fclose($handle);

        return redirect()->route('siswa.index')
            ->with('success', "$success siswa berhasil diimpor.")
            ->with('import_errors', $failed);
    }

    /**
     * Ekspor seluruh data siswa yang ada di database ke file CSV.
     * Password tidak diikutkan karena tersimpan terenkripsi (hash), bukan teks asli.
     */
    public function export() {
        $columns = ['nama','nis','nisn','email','jenis_kelamin','tempat_lahir','tanggal_lahir','alamat','nama_ayah','nama_ibu','nama_wali','no_hp_ortu','kelas','status'];

        return response()->streamDownload(function () use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);

            Siswa::with(['kelas', 'user'])->orderBy('nama')->chunk(200, function ($siswas) use ($out) {
                foreach ($siswas as $s) {
                    fputcsv($out, [
                        $s->nama,
                        $s->nis,
                        $s->nisn,
                        $s->user->email ?? '',
                        $s->jenis_kelamin,
                        $s->tempat_lahir,
                        $s->tanggal_lahir,
                        $s->alamat,
                        $s->nama_ayah,
                        $s->nama_ibu,
                        $s->nama_wali,
                        $s->no_hp_ortu,
                        $s->kelas->nama ?? '',
                        $s->status,
                    ]);
                }
            });

            fclose($out);
        }, 'data_siswa_' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
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