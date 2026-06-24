<?php
namespace App\Http\Controllers;
use App\Models\{Pembelajaran, Guru, MataPelajaran, Kelas, TahunPelajaran};
use Illuminate\Http\Request;

class PembelajaranController extends Controller
{
    public function index(Request $request)
    {
        $tapels = TahunPelajaran::orderByDesc('id')->get();

        $pembelajaran = Pembelajaran::with(['guru','mataPelajaran','kelas'])
            ->when($request->tahun_pelajaran_id, function($q) use ($request) {
                $q->where('tahun_pelajaran_id', $request->tahun_pelajaran_id);
            })
            ->paginate(request('per_page', 15))
            ->appends($request->only('tahun_pelajaran_id', 'per_page'));

        return view('admin.pembelajaran.index', compact('pembelajaran', 'tapels'));
    }

    public function create()
    {
        return view('admin.pembelajaran.form', [
            'gurus'  => Guru::orderBy('nama')->get(),
            'mapels' => MataPelajaran::orderBy('nama')->get(),
            'kelas'  => Kelas::orderBy('nama')->get(),
            'tapels' => TahunPelajaran::orderByDesc('id')->get(),
            'item'   => null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id'            => 'required',
            'mata_pelajaran_id'  => 'required',
            'kelas_id'           => 'required',
            'tahun_pelajaran_id' => 'required',
        ]);

        // Cek duplikat
        $exists = Pembelajaran::where('guru_id', $request->guru_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'mata_pelajaran_id' => 'Data pembelajaran ini sudah ada untuk tahun pelajaran tersebut.'
            ]);
        }

        // Status otomatis ikut status tahun pelajaran
        $tapel = TahunPelajaran::find($request->tahun_pelajaran_id);
        $status = $tapel && $tapel->aktif ? 'Aktif' : 'Nonaktif';

        Pembelajaran::create(
            $request->only('guru_id','mata_pelajaran_id','kelas_id','tahun_pelajaran_id')
            + ['status' => $status]
        );

        return redirect()->route('pembelajaran.index')->with('success','Data pembelajaran berhasil ditambahkan!');
    }

    public function edit(Pembelajaran $pembelajaran)
    {
        return view('admin.pembelajaran.form', [
            'gurus'  => Guru::orderBy('nama')->get(),
            'mapels' => MataPelajaran::orderBy('nama')->get(),
            'kelas'  => Kelas::orderBy('nama')->get(),
            'tapels' => TahunPelajaran::orderByDesc('id')->get(),
            'item'   => $pembelajaran,
        ]);
    }

    public function update(Request $request, Pembelajaran $pembelajaran)
    {
        $request->validate([
            'guru_id'            => 'required',
            'mata_pelajaran_id'  => 'required',
            'kelas_id'           => 'required',
            'tahun_pelajaran_id' => 'required',
        ]);

        // Cek duplikat kecuali data diri sendiri
        $exists = Pembelajaran::where('guru_id', $request->guru_id)
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('kelas_id', $request->kelas_id)
            ->where('tahun_pelajaran_id', $request->tahun_pelajaran_id)
            ->where('id', '!=', $pembelajaran->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'mata_pelajaran_id' => 'Data pembelajaran ini sudah ada untuk tahun pelajaran tersebut.'
            ]);
        }

        // Status otomatis ikut status tahun pelajaran
        $tapel = TahunPelajaran::find($request->tahun_pelajaran_id);
        $status = $tapel && $tapel->aktif ? 'Aktif' : 'Nonaktif';

        $pembelajaran->update(
            $request->only('guru_id','mata_pelajaran_id','kelas_id','tahun_pelajaran_id')
            + ['status' => $status]
        );

        return redirect()->route('pembelajaran.index')->with('success','Data pembelajaran berhasil diperbarui!');
    }

    public function destroy(Pembelajaran $pembelajaran)
    {
        $pembelajaran->delete();
        return redirect()->route('pembelajaran.index')->with('success','Data pembelajaran berhasil dihapus!');
    }
}