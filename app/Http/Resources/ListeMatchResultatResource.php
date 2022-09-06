<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ListeMatchResultatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $this->date_match = 'Le '. Carbon::parse($this->date_match)->translatedFormat('d F Y');
        $this->date_match = Carbon::parse($this->date_match)->translatedFormat('d F Y');

        // Calcul séparation du score
        $pos = strpos($this->score, "-"); // position du caractere -
        $calendrierEquipe1Score = (int)substr($this->score,0,$pos);
        $pos++;
        $calendrierEquipe2Score = (int)substr($this->score,$pos);

        // Ajout d'un champ resultat_equipe pour : Victoire, defaite, null et bientot

        return[
            'id'=> $this->id,
            'score'=> $this->score,
            'date_match'=> $this->date_match,
            'heure_match'=> $this->heure_match,
            'equipe1Nom'=> $this->equipe1->nom,
            'equipes1_id'=> $this->equipes1_id,
            'equipe2Nom'=> $this->equipe2->nom,
            'equipes2_id'=> $this->equipes2_id,
            'commentaire'=> $this->commentaire,
        ];

        return parent::toArray($request);
    }
}
