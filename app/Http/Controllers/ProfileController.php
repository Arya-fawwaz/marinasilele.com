<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil
     */
    public function edit()
    {
        return view('profile.edit');
    }

    /**
     * Memperbarui Nama dan Email Biodata
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Memperbarui Foto Profil (Avatar) langsung ke folder Public
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            // Hapus file avatar lama di folder public jika ada agar hemat memori
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            // Membuat nama file baru yang unik agar tidak tabrakan di sistem
            $filename = time() . '_' . uniqid() . '.' . $request->file('avatar')->getClientOriginalExtension();
            
            // Pindahkan file secara fisik langsung ke public/uploads/avatars
            $request->file('avatar')->move(public_path('uploads/avatars'), $filename);
            
            // Simpan path relatifnya ke database kolom avatar
            $user->update([
                'avatar' => 'uploads/avatars/' . $filename
            ]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Memperbarui Kata Sandi / Password Akun
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Kata sandi berhasil diperbarui!');
    }
}