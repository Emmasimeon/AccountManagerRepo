<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Setup;
use View;

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
        $Details = Setup::first()->get();

        View::composer('accountant.inc.header', function($view) use($Details) {
        $view->with('Details', $Details);
        });

        View::composer('accountant.dashboard', function($view) use($Details) {
            $view->with('Details', $Details);
            });

        View::composer('accountant.payment_voucher', function($view) use($Details) {
            $view->with('Details', $Details);
            });

        View::composer('accountant.payment_voucher_history', function($view) use($Details) {
            $view->with('Details', $Details);
            });
    }
}
