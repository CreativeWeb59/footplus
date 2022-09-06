<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Championnat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'logo'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function classements()
    {
        return $this->hasMany(Classement::class);
    }

    public function listeMatchs()
    {
        return $this->hasMany(ListeMatchs::class);
    }
    
}
