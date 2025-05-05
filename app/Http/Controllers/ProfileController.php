<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Profile Pengguna',
            'list' => ['Home', 'Kategori'],
        ];

        $page = (object)[
            'title' => 'Profile Pengguna'
        ];

        $user = Auth::user();
        $activeMenu = 'profile'; //set menu yang sedang aktif
        return view('profile.index', compact('breadcrumb', 'page', 'activeMenu', 'user'));
    }
    public function editProfile()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }

    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            // Update foto di database
            $user->photo = 'images/' . $filename;
            $user->save();

            return response()->json([
                'success' => true,
                'new_image_url' => asset('images/' . $filename)
            ]);
        }

        return response()->json(['success' => false], 500);
    }
}
