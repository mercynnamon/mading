<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';

    protected $fillable = [
        'judul',
        'isi',
        'konten',
        'foto',
        'status',
        'id_user',
        'id_kategori',
    ];

    // Relasi ke User (penulis)
    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Like
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_artikel', 'id_artikel');
    }

    // Cek apakah user sudah like artikel ini
    public function isLikedBy($user)
    {
        if (is_object($user)) {
            return $this->likes()->where('id_user', $user->id_user)->exists();
        }
        return $this->likes()->where('id_user', $user)->exists();
    }

    // Jumlah like
    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }
    
    public function totalLikes()
    {
        return $this->likes_count ?? $this->likes()->count();
    }
    
    // Relasi ke Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    
    // Relasi ke Komentar
    public function komentars()
    {
        return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel');
    }
    
    // Jumlah komentar
    public function getKomentarsCountAttribute()
    {
        return $this->komentars()->count();
    }
    
    public function totalKomentars()
    {
        return $this->komentars_count ?? $this->komentars()->count();
    }

    // Di dalam class Artikel
public function komentar()
{
    return $this->hasMany(Komentar::class, 'id_artikel', 'id_artikel')->orderBy('created_at', 'desc');
}

// Jumlah komentar
public function totalKomentar()
{
    return $this->komentar()->count();
}

// Di dalam class Artikel
public function getStatusBadgeAttribute()
{
    switch ($this->status) {
        case 'draft':
            return '<span class="status-badge status-draft">Draft</span>';
        case 'publish':
            return '<span class="status-badge status-published">Publish</span>';
        case 'rejected':
            return '<span class="status-badge status-rejected">Ditolak</span>';
        default:
            return '<span class="status-badge">-</span>';
    }
}
}