<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Like;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtikelDetailController extends Controller
{
    // Tampilkan detail artikel
    public function show($id)
    {
        $artikel = Artikel::with(['penulis', 'komentar.user'])->findOrFail($id);

        // Cek apakah user sudah like artikel ini
        $isLiked = false;
        if (Auth::check()) {
            $isLiked = Like::where('id_artikel', $id)
                ->where('id_user', Auth::id())
                ->exists();
        }

        return view('siswa.artikel-detail', compact('artikel', 'isLiked'));
    }

    // Tambah komentar
    public function storeKomentar(Request $request, $id)
    {
        $request->validate([
            'isi' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'id_artikel' => $id,
            'id_user' => Auth::id(),
            'isi' => $request->isi,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }
}