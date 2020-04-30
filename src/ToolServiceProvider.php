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

        $config = collect(SmsPanel::options())->pluck('value', 'key');

        \Config::set('armin-sms.username', $config->get('username'));
        \Config::set('armin-sms.password', $config->get('password'));
        \Config::set('armin-sms.from', $config->get('number'));
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
