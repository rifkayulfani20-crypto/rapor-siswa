<?php
namespace App\Http\Controllers;
use App\Models\{Guru, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GuruController extends Controller {
    public function index() {
        $gurus = Guru::with('user')->latest()->paginate(15);
        return view('admin.guru.index', compact('gurus'));
    }

    public function create() { return view('admin.guru.form'); }

    public function store(Request $request) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nip'           => 'nullable|numeric|digits_between:1,20|unique:gurus',
            'nuptk'         => 'nullable|numeric|digits_between:1,20|unique:gurus',
            'email'         => 'required|email|unique:users',
            'no_hp'         => 'nullable|numeric|digits_between:8,15',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat'        => 'nullable|string',
            'password'      => 'required|min:6',
        ]);
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);
        Guru::create([
            'nama'          => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nip'           => $request->nip,
            'nuptk'         => $request->nuptk,
            'no_hp'         => $request->no_hp,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat'        => $request->alamat,
            'user_id'       => $user->id,
        ]);
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show(Guru $guru) {
        $guru->load('user');
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru) { return view('admin.guru.form', compact('guru')); }

    public function update(Request $request, Guru $guru) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nip'           => 'nullable|numeric|digits_between:1,20|unique:gurus,nip,'.$guru->id,
            'email'         => 'required|email|unique:users,email,'.($guru->user_id ?? 0),
            'no_hp'         => 'nullable|numeric|digits_between:8,15',
        ]);
        $guru->update($request->only('nama','jenis_kelamin','nip','nuptk','no_hp','tempat_lahir','tanggal_lahir','alamat'));
        if ($guru->user) {
            $guru->user->update(['name'=>$request->nama,'email'=>$request->email]);
            if ($request->filled('password')) {
                $guru->user->update(['password'=>Hash::make($request->password)]);
            }
        }
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    public function destroy(Guru $guru) {
        $guru->user?->delete();
        $guru->delete();
        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }

    /**
     * Unduh template CSV untuk import guru massal.
     */
    public function downloadTemplate() {
        $columns = ['nama','jenis_kelamin','nip','nuptk','no_hp','tempat_lahir','tanggal_lahir','alamat','email','password'];
        $contoh  = ['Siti Rahma','P','','','081234567890','Bandung','1988-03-20','Jl. Pendidikan No. 5','siti@sekolah.sch.id',''];

        return response()->streamDownload(function () use ($columns, $contoh) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fputcsv($out, $contoh);
            fclose($out);
        }, 'template_import_guru.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * Import guru secara massal dari file CSV.
     * Kolom 'password' boleh dikosongkan → default memakai 6 digit awal email (sebelum @).
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
                continue;
            }

            $data = array_combine($header, array_pad($row, count($header), null));

            $validator = Validator::make($data, [
                'nama'          => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'nip'           => 'nullable|numeric|digits_between:1,20|unique:gurus,nip',
                'nuptk'         => 'nullable|numeric|digits_between:1,20|unique:gurus,nuptk',
                'email'         => 'required|email|unique:users,email',
                'no_hp'         => 'nullable|numeric|digits_between:8,15',
                'tanggal_lahir' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                $failed[] = "Baris $rowNum: " . implode(', ', $validator->errors()->all());
                continue;
            }

            try {
                $password = !empty($data['password']) ? $data['password'] : substr($data['email'], 0, strpos($data['email'], '@'));

                $user = User::create([
                    'name'     => $data['nama'],
                    'email'    => $data['email'],
                    'password' => Hash::make($password),
                    'role'     => 'guru',
                ]);

                Guru::create([
                    'nama'          => $data['nama'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'nip'           => $data['nip'] ?: null,
                    'nuptk'         => $data['nuptk'] ?: null,
                    'no_hp'         => $data['no_hp'] ?: null,
                    'tempat_lahir'  => $data['tempat_lahir'] ?: null,
                    'tanggal_lahir' => $data['tanggal_lahir'] ?: null,
                    'alamat'        => $data['alamat'] ?: null,
                    'user_id'       => $user->id,
                ]);

                $success++;
            } catch (\Throwable $e) {
                $failed[] = "Baris $rowNum: gagal disimpan ({$e->getMessage()})";
            }
        }

        fclose($handle);

        return redirect()->route('guru.index')
            ->with('success', "$success guru berhasil diimpor.")
            ->with('import_errors', $failed);
    }

    /**
     * Ekspor seluruh data guru yang ada di database ke file CSV.
     */
    public function export() {
        $columns = ['nama','jenis_kelamin','nip','nuptk','no_hp','tempat_lahir','tanggal_lahir','alamat','email'];

        return response()->streamDownload(function () use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);

            Guru::with('user')->orderBy('nama')->chunk(200, function ($gurus) use ($out) {
                foreach ($gurus as $g) {
                    fputcsv($out, [
                        $g->nama,
                        $g->jenis_kelamin,
                        $g->nip,
                        $g->nuptk,
                        $g->no_hp,
                        $g->tempat_lahir,
                        $g->tanggal_lahir,
                        $g->alamat,
                        $g->user->email ?? '',
                    ]);
                }
            });

            fclose($out);
        }, 'data_guru_' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }
}