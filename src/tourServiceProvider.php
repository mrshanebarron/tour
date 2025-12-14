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
        $this->mergeConfigFrom(__DIR__ . '/../config/sb-tour.php', 'sb-tour');
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sb-tour');

        Livewire::component('sb-tour', tour::class);

        $this->loadViewComponentsAs('ld', [
            Bladetour::class,
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
