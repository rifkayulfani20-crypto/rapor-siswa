<?php

namespace App\Http\Controllers;

use App\Models\TahunPelajaran;
use Illuminate\Http\Request;

class KepsekController extends Controller
{
    public function dashboard()
    {
        $tapels = TahunPelajaran::orderByDesc('aktif')->orderByDesc('id')->get();

        return view('kepsek.dashboard', compact('tapels'));
    }

    public function lock(TahunPelajaran $tapel)
    {
        $tapel->update(['is_locked' => true]);

        return back()->with('success', "Nilai untuk tahun pelajaran \"{$tapel->nama}\" berhasil dikunci.");
    }

    public function unlock(TahunPelajaran $tapel)
    {
        $tapel->update(['is_locked' => false]);

        return back()->with('success', "Nilai untuk tahun pelajaran \"{$tapel->nama}\" berhasil dibuka.");
    }
}