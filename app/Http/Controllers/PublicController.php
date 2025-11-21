<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Pengunjung dapat melihat halaman ini tanpa login
        
        $artikelTerbaru = Artikel::with(['penulis', 'kategori'])
            ->withCount(['likes', 'komentars'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        $kategoris = Kategori::withCount(['artikel' => function($query) {
            $query->where('status', 'publish');
        }])->get();
        
        return view('public.index', compact('artikelTerbaru', 'kategoris'));
    }

    public function artikel($id)
    {
        $artikel = Artikel::with(['penulis', 'kategori', 'komentars.user'])
            ->where('id_artikel', $id)
            ->where('status', 'publish')
            ->firstOrFail();
            
        $artikelTerkait = Artikel::with(['penulis', 'kategori'])
            ->where('id_kategori', $artikel->id_kategori)
            ->where('id_artikel', '!=', $id)
            ->where('status', 'publish')
            ->take(3)
            ->get();
            
        return view('public.artikel', compact('artikel', 'artikelTerkait'));
    }

    public function kategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        $artikel = Artikel::with(['penulis', 'kategori'])
            ->withCount(['likes', 'komentars'])
            ->where('id_kategori', $id)
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->paginate(9);
            
        return view('public.kategori', compact('artikel', 'kategori'));
    }
}