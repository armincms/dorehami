<?php

namespace Armincms\Dorehami;
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider; 

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    { 
        $this->app->booted(function () {
            $this->routes();
        }); 
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['auth:api'])
                ->namespace(__NAMESPACE__.'\\Http\\Controllers')
                ->prefix('api/dorehami')
                ->group(__DIR__.'/../routes/api.php');
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
