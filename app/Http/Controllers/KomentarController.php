<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'isi' => 'required|string|max:1000'
        ]);

        $artikel = Artikel::findOrFail($id);
        
        Komentar::create([
            'id_artikel' => $id,
            'id_user' => Auth::user()->id_user,
            'isi' => $request->isi
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}