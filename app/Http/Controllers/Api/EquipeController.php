<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\EquipeRepository;

class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipes = Equipe::orderBy('nom', 'ASC')->get();
        
        $cx_saison = 2;
        $equipes=Equipe::with('equipe1','equipe2')
            ->where([['seasons_id',$cx_saison],['score','<>','-']])
            ->orderBy('date_match', 'desc')
            ->get();
        $equipes = $equipes->sortBy('equipe.nom');
        
        return response()->json($equipes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$equipe = Equipe::where('id', $request->equipeId->first());
        $equipe = Equipe::find($request->equipeId);
        //$count = (new EquipeRepository())->add($equipe);
        return $equipe;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
