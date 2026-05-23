<?php
namespace App\Http\Controllers;
use App\Models\{Guru, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'nip'           => 'nullable|string|unique:gurus',
            'nuptk'         => 'nullable|string|unique:gurus',
            'email'         => 'required|email|unique:users',
            'no_hp'         => 'nullable|string',
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

    public function edit(Guru $guru) { return view('admin.guru.form', compact('guru')); }

    public function update(Request $request, Guru $guru) {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nip'           => 'nullable|string|unique:gurus,nip,'.$guru->id,
            'email'         => 'required|email|unique:users,email,'.($guru->user_id ?? 0),
            'no_hp'         => 'nullable|string',
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
}