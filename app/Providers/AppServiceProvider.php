<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Pest\Support\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(100);
        URL::forceRootUrl(config('app.url'));
        Paginator::useBootstrap();
        /**set time zone */

        $generalSetting=GeneralSetting::first();
        Config::set('app.timezone', $generalSetting->time_zone);

        /** share variable at all value */

        view()->composer('*', function ($view) use ($generalSetting) {
            $view->with('settings', $generalSetting);
            
        });
    }
}
