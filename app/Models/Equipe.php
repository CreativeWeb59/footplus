<?php

namespace App\Models;

use App\Models\Season;
use App\Models\Classement;
use App\Models\ListeMatch;
use App\Models\Championnat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'logo'
    ];

    public function listeMatchs()
    {
        return $this->belongsTo(ListeMatch::class);
    }

    public function classements()
    {
        return $this->hasMany(Classement::class);
    }

    public function seasons()
    {
    //  return $this->belongsToMany(Season::class, 'historique_equipes');
    }
    
    public function championnats()
    {
         return $this->hasMany(Championnat::class);
    //    return $this->belongsToMany(Championnat::class, 'historique_equipes');
    }
}
