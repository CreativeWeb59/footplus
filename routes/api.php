<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EquipeController;
use App\Http\Controllers\Api\SeasonController;
use App\Http\Controllers\Api\ClassementController;
use App\Http\Controllers\Api\ListeMatchController;
use App\Http\Controllers\Api\ChampionnatController;
use App\Http\Controllers\Api\StatistiqueController;
use App\Http\Controllers\Api\HistoriqueEquipesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('equipes', EquipeController::class);
    Route::get('historiqueEquipes', [HistoriqueEquipesController::class, 'index']);
    Route::post('historiqueEquipes', [HistoriqueEquipesController::class, 'show']);
    Route::get('statistiqueEquipes', [StatistiqueController::class, 'index']);
    Route::post('statistiqueEquipes', [StatistiqueController::class, 'show']);
    Route::post('listeMatchs', [ListeMatchController::class, 'list']);
    Route::get('classements', [ClassementController::class, 'index']);
    Route::post('classements', [ClassementController::class,'show']);
    Route::get('seasons', [SeasonController::class, 'index']);
    Route::get('championnats', [ChampionnatController::class, 'index']);
    Route::get('calendrier', [ListeMatchController::class, 'index']);
    Route::post('calendrier', [ListeMatchController::class, 'show']);
    Route::put('calendrier', [ListeMatchController::class, 'update']);
    Route::patch('calendrier', [ListeMatchController::class, 'updateScoreEquipe']);
    Route::patch('calendrierCom', [ListeMatchController::class, 'updateCommentaire']);

});