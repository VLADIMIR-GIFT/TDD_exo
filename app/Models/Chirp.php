<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chirp extends Model
{
    use HasFactory;

    // Définir les champs remplissables
    protected $fillable = ['content', 'user_id'];

    public function likes()
    {
        return $this->belongsToMany(User::class, 'chirp_likes');
    }
}
