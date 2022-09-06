<?php

namespace App\Http\Controllers\Api;

use App\Models\Championnat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChampionnatController extends Controller
{
    public function index()
    {
        $championnat = Championnat::all();
        return response()->json($championnat);
    }
}
