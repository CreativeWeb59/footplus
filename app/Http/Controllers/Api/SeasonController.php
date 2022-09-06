<?php

namespace App\Http\Controllers\Api;

use App\Models\Season;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeasonController extends Controller
{
    public function index()
    {
        $season = Season::all();
        return response()->json($season);
    }
}
