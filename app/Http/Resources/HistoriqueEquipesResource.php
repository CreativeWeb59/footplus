<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Historique_equipes;

class HistoriqueEquipesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
            // valeurs par defaut a retirer d'une table options
            $cx_saison = 3;
            $cx_championnat = 1;
    
            $equipes = Historique_equipes::with(['equipe'=> function ($q) {
                $q->orderBy('nom','asc');
                }])    
                ->where('season_id',3)
                ->where('championnat_id',1)
                ->get();
        
        return parent::toArray($request);
    }
}
