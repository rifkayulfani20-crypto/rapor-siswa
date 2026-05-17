<?php
namespace App\Http\Controllers;
use App\Models\TahunPelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TahunPelajaranController extends Controller {
    public function index() {
        $tapels = TahunPelajaran::latest()->paginate(10);
        return view('tapel.index', compact('tapels'));
    }
    public function create() { return view('tapel.form', ['tapel'=>null]); }
    public function store(Request $request) {
        $request->validate(['nama'=>'required','semester'=>'required|in:Ganjil,Genap']);
        if ($request->aktif) TahunPelajaran::where('aktif',true)->update(['aktif'=>false]);
        TahunPelajaran::create($request->only('nama','semester','tempat_pembagian','tanggal_pembagian') + ['aktif'=>$request->boolean('aktif')]);
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil ditambahkan!');
    }
    public function edit(TahunPelajaran $tapel) { return view('tapel.form', compact('tapel')); }
    public function update(Request $request, TahunPelajaran $tapel) {
        $request->validate(['nama'=>'required','semester'=>'required|in:Ganjil,Genap']);
        if ($request->aktif) TahunPelajaran::where('aktif',true)->where('id','!=',$tapel->id)->update(['aktif'=>false]);
        $tapel->update($request->only('nama','semester','tempat_pembagian','tanggal_pembagian') + ['aktif'=>$request->boolean('aktif')]);
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil diperbarui!');
    }
    public function destroy(TahunPelajaran $tapel) {
        $tapel->delete();
        return redirect()->route('tapel.index')->with('success','Tahun pelajaran berhasil dihapus!');
    }
}