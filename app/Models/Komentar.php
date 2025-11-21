<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;

    protected $table = 'komentar';
    protected $primaryKey = 'id_komentar';

    protected $fillable = ['isi', 'id_artikel', 'id_user'];

    public function artikel()
    {
        return $this->belongsTo(Artikel::class, 'id_artikel', 'id_artikel');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}