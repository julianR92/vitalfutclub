<?php

namespace App\Providers;

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
        // Para producción con estructura separada
        if (file_exists(base_path().'/../vitaladmin')) {
            $this->app->bind('path.public', function() {
                return base_path().'/../vitaladmin';
            });
        }
    }
}
