<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $articles = Artikel::with(['penulis', 'kategori'])
            ->withCount(['likes', 'komentars'])
            ->where('status', 'publish')
            ->where(function($q) use ($query) {
                $q->where('judul', 'LIKE', "%{$query}%")
                  ->orWhere('konten', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        if ($request->ajax || $request->get('ajax')) {
            $html = '';
            foreach ($articles as $artikel) {
                $html .= '<div class="col-md-4 mb-3 artikel-item">';
                $html .= '<div class="card" style="cursor: pointer;" onclick="window.location.href=\'/artikel-detail/' . $artikel->id_artikel . '\'">';
                $html .= '<img src="' . ($artikel->foto ? asset('storage/' . $artikel->foto) : 'https://via.placeholder.com/300x180?text=No+Image') . '" class="card-img-top" alt="' . $artikel->judul . '">';
                $html .= '<div class="card-body">';
                $html .= '<h6 class="card-title">' . \Str::limit($artikel->judul, 30) . '</h6>';
                $html .= '<p class="card-text text-muted small">Oleh: ' . ($artikel->penulis->nama ?? 'Admin') . '</p>';
                $html .= '<div class="d-flex justify-content-between align-items-center">';
                $html .= '<div><span class="text-danger"><i class="fas fa-heart"></i> ' . $artikel->likes_count . '</span></div>';
                $html .= '<small class="text-muted">' . $artikel->created_at->diffForHumans() . '</small>';
                $html .= '</div></div></div></div>';
            }
            
            if (empty($html)) {
                $html = '<div class="col-12 text-center py-5"><i class="fas fa-search fa-3x text-muted mb-3"></i><h5 class="text-muted">Tidak ada artikel ditemukan</h5></div>';
            }
            
            return response($html);
        }
            
        return view('search.results', compact('articles', 'query'));
    }
}