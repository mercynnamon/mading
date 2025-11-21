<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Like;
use App\Models\Kategori;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function dashboard()
    {
        $artikelPending = Artikel::with('penulis')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('dashboard.guru', compact('artikelPending'));
    }

    public function artikelSaya()
    {
        $articles = Artikel::where('id_user', auth()->user()->id_user)
            ->with('kategori')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('guru.artikel-saya', compact('articles'));
    }

    public function artikelPending()
    {
        $articles = Artikel::where('status', 'pending')
            ->with(['penulis', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('guru.artikel-pending', compact('articles'));
    }

    public function approveArtikel($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'publish']);
        return back()->with('success', 'Artikel berhasil disetujui!');
    }

    public function rejectArtikel($id)
    {
        Artikel::where('id_artikel', $id)->update(['status' => 'draft']);
        return back()->with('success', 'Artikel ditolak!');
    }

    public function artikelDisukai()
    {
        $likedArticles = Artikel::whereHas('likes', function($query) {
            $query->where('id_user', auth()->user()->id_user);
        })
        ->with(['penulis', 'kategori'])
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('guru.artikel-disukai', compact('likedArticles'));
    }

    public function profil()
    {
        return view('guru.profil');
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
        $kategoris = Kategori::all();
        return view('guru.buat-artikel', compact('kategoris'));
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

        Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->isi,
            'id_user' => auth()->user()->id_user,
            'id_kategori' => $request->id_kategori,
            'foto' => $fotoPath,
            'status' => 'publish'
        ]);

        return redirect()->route('guru.dashboard')->with('success', 'Artikel berhasil dibuat!');
    }
}