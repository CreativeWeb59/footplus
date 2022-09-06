<?php

namespace App\Providers;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ajout pour fonctionnement des migrations
        Schema::defaultStringLength(191);

        // ajout pour la date en francais
        Carbon::setLocale('fr');
        // utilise la variable locale
        // Carbon::setLocale(config('app.locale'));
    }
}
