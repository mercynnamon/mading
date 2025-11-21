<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function create()
    {
        $kategoris = Kategori::all();
        return view('dashboard.siswa.buat-artikel', compact('kategoris'));
    }

    public function store(Request $request)
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

        $status = Auth::user()->role === 'guru' ? 'publish' : 'pending';
        
        Artikel::create([
            'judul' => $request->judul,
            'konten' => $request->isi,
            'id_user' => Auth::user()->id_user,
            'id_kategori' => $request->id_kategori,
            'foto' => $fotoPath,
            'status' => $status
        ]);

        $redirectRoute = Auth::user()->role === 'guru' ? 'guru.dashboard' : 'siswa.dashboard';
        $message = Auth::user()->role === 'guru' ? 
            'Artikel berhasil dibuat dan langsung dipublikasi!' : 
            'Artikel berhasil dibuat dan menunggu persetujuan guru!';
            
        return redirect()->route($redirectRoute)->with('success', $message);
    }

    public function show($id)
    {
        $artikel = Artikel::with(['penulis', 'kategori', 'komentars.user'])
            ->where('id_artikel', $id)
            ->firstOrFail();
        
        return view('artikel.detail', compact('artikel'));
    }

    public function destroy($id)
    {
        $artikel = Artikel::where('id_artikel', $id)
            ->where('id_user', auth()->user()->id_user)
            ->first();
            
        if ($artikel) {
            if ($artikel->foto) {
                Storage::disk('public')->delete($artikel->foto);
            }
            $artikel->delete();
            return back()->with('success', 'Artikel berhasil dihapus!');
        }
        
        return back()->with('error', 'Artikel tidak ditemukan!');
    }
}