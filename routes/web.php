<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ParisController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\JourneesController;
use App\Http\Controllers\ClassementController;
use App\Http\Controllers\ListeMatchController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\statsJourneesController;
use App\Http\Controllers\HistoriqueEquipesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [HomeController::class, 'index'])->name(('/'));

Route::get('equipes', [EquipeController::class, 'index'])->name(('equipes.index'));
Route::get('listeequipes', [HistoriqueEquipesController::class, 'index'])->name(('HistoriqueEquipesController.index'));
Route::get('paris', [ParisController::class, 'index'])->name(('paris.index'));
Route::get('choixChamp', [EquipeController::class, 'index'])->name(('choixChamp.index'));
Route::get('classement', [ClassementController::class, 'index'])->name(('classement.index'));
Route::get('listematchs', [ListeMatchController::class, 'index'])->name(('listematchs.index'));
// Route::post('listeMatchs', [ListeMatchController::class,'listeMatchs'])->name ('ListeMatchController.listeMatchs');

Route::get('majJournees', [JourneesController::class,'index'])-> name ('JourneesController.index')->middleware('auth');
Route::put('/storeMatch', [JourneesController::class,'store'])-> name ('JourneesController.store')->middleware('auth');

Route::get('statistiques', [StatistiquesController::class,'index'])-> name ('StatistiquesController.index');
Route::get('statsJournees', [statsJourneesController::class,'index'])-> name ('statsJourneesController.index');

//Route::resource('equipes', EquipeController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
