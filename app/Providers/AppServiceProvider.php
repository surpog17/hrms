<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        //
        Schema::defaultStringLength(191);
        Blade::if('emp', function () {
            if (auth()->user()->google_id && !auth()->user()->hr && !auth()->user()->finance){
                return true;
            }
            return false;
        });
        Blade::if('employ', function () {
            if (auth()->user()->google_id){
                return true;
            }
            return false;
        });
        Blade::if('hr', function () {
            if (auth()->user()->google_id && auth()->user()->hr){
                return true;
            }
            return false;
        });
        Blade::if('fin', function () {
            if (auth()->user()->google_id && auth()->user()->finance){
                return true;
            }
            return false;
        });
    }
}
