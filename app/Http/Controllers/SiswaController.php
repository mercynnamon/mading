<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Like;
use App\Models\Kategori;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $artikelTerbaru = Artikel::with('penulis')
            ->withCount(['likes', 'komentars'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $artikelMaya = Artikel::with('penulis')
            ->withCount(['likes', 'komentars'])
            ->where('id_user', auth()->user()->id_user)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard.siswa.siswa', compact('artikelTerbaru', 'artikelMaya'));
    }

    public function artikelSaya()
    {
        $articles = Artikel::where('id_user', auth()->user()->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('siswa.artikel-saya', compact('articles'));
    }

    public function artikelDisukai()
    {
        $likedArticles = Artikel::whereHas('likes', function($query) {
            $query->where('id_user', auth()->user()->id_user);
        })
        ->with(['penulis', 'kategori'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('siswa.artikel-disukai', compact('likedArticles'));
    }

    public function profil()
    {
        return view('siswa.profil');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->user()->id_user . ',id_user'
        ]);

        auth()->user()->update([
            'nama' => $request->nama,
            'username' => $request->username
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function createArtikel()
    {
        $kategoris = \App\Models\Kategori::all();
        return view('dashboard.siswa.buat-artikel', compact('kategoris'));
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'isi' => 'required|string',
            'foto' => 'nullable|image|max:2048'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('artikel', 'public');
        }

        \App\Models\Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->isi,
            'id_user' => auth()->user()->id_user,
            'id_kategori' => $request->id_kategori,
            'foto' => $fotoPath,
            'status' => 'pending'
        ]);

        return redirect()->route('siswa.artikel-saya')->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan!');
    }


}