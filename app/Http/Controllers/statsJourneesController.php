<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class statsJourneesController extends Controller
{
    public function index ()
    {
        // $equipes = 'équipes';
        // $classements = 'classement';
        return view('statsJournees.index');
    }
}
