<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akuns = User::latest()->paginate(10);
        return view('admin.akun.index', compact('akuns'));
    }

    public function edit(User $akun)
    {
        return view('admin.akun.form', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|unique:users,username,' . $akun->id,
            'email'    => 'nullable|email|unique:users,email,' . $akun->id,
        ]);

        $akun->update($request->only('name', 'username', 'email'));

        if ($request->filled('password')) {
            $akun->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.akun.index')->with('success', 'Data akun berhasil diperbarui!');
    }
}