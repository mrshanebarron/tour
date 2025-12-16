<?php

namespace MrShaneBarron\Tour;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\Tour\Livewire\Tour;
use MrShaneBarron\Tour\View\Components\Tour as BladeTour;
use Livewire\Livewire;

class TourServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-tour.php', 'sb-tour');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-tour');

        Livewire::component('sb-tour', Tour::class);

        $this->loadViewComponentsAs('ld', [
            BladeTour::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/sb-tour.php' => config_path('sb-tour.php'),
            ], 'sb-tour-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/sb-tour'),
            ], 'sb-tour-views');
        }
    }
}
