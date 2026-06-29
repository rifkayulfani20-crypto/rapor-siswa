<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $akuns = $query->latest()
                       ->paginate($request->get('per_page', 10))
                       ->withQueryString();

        return view('admin.akun.index', compact('akuns'));
    }

    public function edit(User $akun)
    {
        return view('admin.akun.form', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $akun->id,
        ]);

        $akun->update($request->only('name', 'email'));

        if ($request->filled('password')) {
            $akun->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.akun.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function updateRole(Request $request, User $akun)
    {
        $request->validate([
            'role' => ['required', 'in:admin,guru,siswa,kepsek'],
        ]);

        if ($akun->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role akun sendiri.');
        }

        $akun->update(['role' => $request->role]);

        return back()->with('success', 'Role ' . $akun->name . ' berhasil diubah ke ' . strtoupper($request->role) . '.');
    }
}