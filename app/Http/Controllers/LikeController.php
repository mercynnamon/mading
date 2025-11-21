<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($id)
    {
        $userId = auth()->user()->id_user;
        $artikel = Artikel::findOrFail($id);
        
        $existingLike = Like::where('id_artikel', $id)
            ->where('id_user', $userId)
            ->first();
        
        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            Like::create([
                'id_artikel' => $id,
                'id_user' => $userId
            ]);
            $liked = true;
        }
        
        $totalLikes = $artikel->totalLikes();
        
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'total_likes' => $totalLikes
        ]);
    }
}