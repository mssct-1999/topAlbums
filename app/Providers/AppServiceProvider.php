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
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app',function($view) {
            $theme = \Cookie::get('theme');
            if ($theme != 'dark' && $theme != 'light') {
                $theme = 'light';
            }
            $view->with('theme',$theme); 
        });

        Blade::directive('admin',function() {
            return "<?php if(App\User::isAdmin(Auth::user())): ?>";
        });

        Blade::directive('endadmin',function() {
            return "<?php endif; ?>";
        });

        Blade::directive('comparaison',function($number) {
            $php = "
            <?php 
                if (isset($number)) {
                    if($number >= 0) {
                        echo \"+\" . $number; 
                    }
                    else {
                        echo $number;
                    }
                }
            ?>";
            return $php;
        });
    }
}
