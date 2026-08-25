<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    // Menampilkan Halaman Utama Profil & Tabel Admin
    public function index()
    {
        $user = Auth::user(); // Admin yang sedang login

        // Mengambil semua user yang memiliki akses admin/kades
        $admins = User::whereIn('role', ['admin', 'kades'])->latest()->get();

        return view('admin.profile', compact('user', 'admins'));
    }

    // Mengupdate Profil Diri Sendiri
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed', // Harus cocok dengan password_confirmation
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, maka update password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    // Menambah Admin Baru (CRUD Modal)
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,kades',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Admin baru berhasil ditambahkan!');
    }

    // Mengupdate Admin Lain (CRUD Modal)
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'role' => 'required|in:admin,kades',
            'password' => 'nullable|string|min:8',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->role = $request->role;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Data admin berhasil diperbarui!');
    }

    // Menghapus Admin (CRUD Modal)
    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);

        // Mencegah admin menghapus dirinya sendiri
        if ($admin->id == Auth::id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri!']);
        }

        $admin->delete();

        return back()->with('success', 'Akun admin berhasil dihapus!');
    }
}
