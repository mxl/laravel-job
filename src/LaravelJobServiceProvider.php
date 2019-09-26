<?php


namespace MichaelLedin\LaravelJob;


use Illuminate\Support\ServiceProvider;
use MichaelLedin\LaravelJob\Commands\Dispatch;
use MichaelLedin\LaravelJob\Commands\DispatchNow;

class LaravelJobServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            Dispatch::class,
            DispatchNow::class
        ]);
    }
}