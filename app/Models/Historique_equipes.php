<?php

namespace App\Models;

use App\Models\Equipe;
use App\Models\Season;
use App\Models\Championnat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historique_equipes extends Model
{
    use HasFactory;

    public function equipe()
    {
        return $this->belongsTo(Equipe::class,'equipe_id')->orderBy('nom','asc');
    }

    public function season()
    {
        return $this->belongsTo(Season::class,'season_id');
    }

    public function championnat()
    {
        return $this->belongsTo(Championnat::class,'championnat_id');
    }
}
