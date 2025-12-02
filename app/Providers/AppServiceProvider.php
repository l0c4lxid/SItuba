<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = config('app.locale', 'id');
        App::setLocale($locale);
        Carbon::setLocale($locale);
        Date::setLocale($locale);
        @setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'id', 'id_ID.UTF-8');

        // Prevent index length errors on older MySQL by limiting default string length
        Schema::defaultStringLength(191);
    }
}
