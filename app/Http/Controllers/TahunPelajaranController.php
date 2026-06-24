<?php
namespace App\Http\Controllers;
use App\Models\TahunPelajaran;
use App\Models\Pembelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TahunPelajaranController extends Controller {
    public function index() {
        $tapels = TahunPelajaran::latest()->paginate(10);
        return view('admin.tapel.index', compact('tapels'));
    }

    public function create() { 
        return view('admin.tapel.form', ['tapel'=>null]); 
    }

    public function store(Request $request) {
        $request->validate(['nama'=>'required','semester'=>'required|in:Ganjil,Genap']);
        if ($request->aktif) {
            TahunPelajaran::where('aktif', true)->update(['aktif' => false]);
            // Nonaktifkan semua pembelajaran dulu
            Pembelajaran::query()->update(['status' => 'Nonaktif']);
        }
        $tapel = TahunPelajaran::create(
            $request->only('nama','semester','tempat_pembagian','tanggal_pembagian') 
            + ['aktif' => $request->boolean('aktif')]
        );
        // Aktifkan pembelajaran sesuai tahun pelajaran yang aktif
        if ($request->aktif) {
            Pembelajaran::where('tahun_pelajaran_id', $tapel->id)->update(['status' => 'Aktif']);
        }
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil ditambahkan!');
    }

    public function edit(TahunPelajaran $tapel) { 
        return view('admin.tapel.form', compact('tapel')); 
    }

    public function update(Request $request, TahunPelajaran $tapel) {
        $request->validate(['nama'=>'required','semester'=>'required|in:Ganjil,Genap']);
        if ($request->aktif) {
            TahunPelajaran::where('aktif', true)->where('id', '!=', $tapel->id)->update(['aktif' => false]);
            // Nonaktifkan semua pembelajaran dulu
            Pembelajaran::query()->update(['status' => 'Nonaktif']);
            // Aktifkan pembelajaran sesuai tahun pelajaran yang dipilih aktif
            Pembelajaran::where('tahun_pelajaran_id', $tapel->id)->update(['status' => 'Aktif']);
        } else {
            // Kalau tahun pelajaran ini di-nonaktifkan, nonaktifkan juga pembelajarannya
            Pembelajaran::where('tahun_pelajaran_id', $tapel->id)->update(['status' => 'Nonaktif']);
        }
        $tapel->update(
            $request->only('nama','semester','tempat_pembagian','tanggal_pembagian') 
            + ['aktif' => $request->boolean('aktif')]
        );
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil diperbarui!');
    }

    public function destroy(TahunPelajaran $tapel) {
        $tapel->delete();
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil dihapus!');
    }
}