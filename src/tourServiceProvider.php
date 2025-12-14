<?php

namespace MrShaneBarron\tour;

use Illuminate\Support\ServiceProvider;
use MrShaneBarron\tour\Livewire\tour;
use MrShaneBarron\tour\View\Components\tour as Bladetour;
use Livewire\Livewire;

class tourServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/ld-tour.php', 'ld-tour');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ld-tour');

        Livewire::component('ld-tour', tour::class);

        $this->loadViewComponentsAs('ld', [
            Bladetour::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/ld-tour.php' => config_path('ld-tour.php'),
            ], 'ld-tour-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/ld-tour'),
            ], 'ld-tour-views');
        }
    }
}
