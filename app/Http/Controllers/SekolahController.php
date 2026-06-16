<?php
namespace App\Http\Controllers;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class SekolahController extends Controller {
    public function index() {
        $sekolah = Sekolah::first();
        if (!$sekolah) $sekolah = Sekolah::create(['nama'=>'MTs Rekayasa']);
        return view('sekolah.index', compact('sekolah'));
    }
    public function update(Request $request, Sekolah $sekolah) {
        $request->validate(['nama' => 'required|string|max:255']);
        $data = $request->only('nama','npsn','nss','kode_pos','telepon','email','website','kepala_sekolah','nip_kepala_sekolah');

        $sekolah->update($data);
        return back()->with('success','Data sekolah berhasil diperbarui!');
    }
}