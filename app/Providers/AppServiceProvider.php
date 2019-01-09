<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Admin\users;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function($view){
            if(\Auth::user())
            {
                $view->with('usuario_me', users::me(\Auth::user()->id));    
            }
            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
