<?php

namespace App\Models;

use App\Models\Championnat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListeMatch extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'seasons_id','championnats_id','equipes1_id','equipes2_id','num_journee', 'score', 'commentaire','date_match','heure_match'
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function championnat()
    {
        return $this->belongsTo(Championnat::class);
    }

    public function equipe1()
    {
        return $this->belongsTo(Equipe::class,'equipes1_id');
    }

    public function equipe2()
    {
        return $this->belongsTo(Equipe::class,'equipes2_id');
    }

}
