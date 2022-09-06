<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nom',
    ];

    public function classements()
    {
        return $this->hasMany(Classement::class);
    }

    public function listeMatchs()
    {
        return $this->hasMany(ListeMatchs::class);
    }
}
