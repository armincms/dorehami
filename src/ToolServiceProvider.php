<?php

namespace Armincms\Dorehami;
 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Nova; 

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

        Nova::serving(function() {
            Nova::resources([
                SmsPanel::class
            ]);
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
        $this->app->resolving('qasedak', function() {  
            $config = collect(SmsPanel::options());

            \Config::set('amrin-sms.username', $config->get('username'));
            \Config::set('amrin-sms.password', $config->get('password'));
            \Config::set('amrin-sms.from', $config->get('number')); 
        });
    }
}
