<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StatistiquesController extends Controller
{
    public function index ()
    {
        $equipes = 'équipes';
        $classements = 'classement';
        return view('statistiques.index', compact('equipes', 'classements'));
    }
}
