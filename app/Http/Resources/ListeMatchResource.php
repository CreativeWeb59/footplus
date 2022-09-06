<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ListeMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->date_match = 'Le '. Carbon::parse($this->date_match)->translatedFormat('d F Y');

        // Calcul séparation du score
        $pos = strpos($this->score, "-"); // position du caractere -
        $calendrierEquipe1Score = (int)substr($this->score,0,$pos);
        $pos++;
        $calendrierEquipe2Score = (int)substr($this->score,$pos);

        return[
            'id'=> $this->id,
            'score'=> $this->score,
            'calendrierEquipe1Score'=> $calendrierEquipe1Score,
            'calendrierEquipe2Score'=> $calendrierEquipe2Score,
            'date_match'=> $this->date_match,
            'heure_match'=> $this->heure_match,
            'equipe1Nom'=> $this->equipe1->nom,
            'equipe2Nom'=> $this->equipe2->nom,
            'equipe1Logo'=> $this->equipe1->logo,
            'equipe2Logo'=> $this->equipe2->logo,
            'commentaire'=> $this->commentaire,
        ];

        return parent::toArray($request);
    }
}
