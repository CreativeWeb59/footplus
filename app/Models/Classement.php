<?php

namespace App\Models;

use App\Models\Equipe;
use App\Models\Season;
use App\Models\Championnat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classement extends Model
{
    use HasFactory;

    protected $fillable = [
        'classement_en_cours', 'points ','nb_match_joue','nb_match_gagne','nb_match_null','nb_match_perdu',
        'but_marque','but_encaisse ','difference_but'
    ];

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function championnat()
    {
        return $this->belongsTo(Championnat::class);
    }
}
