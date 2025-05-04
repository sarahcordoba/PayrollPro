<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $menuItems = [
                ['name' => 'Inicio', 'url' => '/', 'icon' => 'bi bi-house-door'],
                //['name' => 'Asistente Habilitación', 'url' => '/asistente', 'icon' => 'bi bi-person-check'],
                ['name' => 'Empleados', 'url' => '/empleados', 'icon' => 'bi bi-person-lines-fill'],
                ['name' => 'Liquidación', 'url' => '/liquidaciones', 'icon' => 'bi bi-cash']
                //['name' => 'Colilla de Pago', 'url' => '/colilla-pago', 'icon' => 'bi bi-file-earmark-text'],
               // ['name' => 'Eliminación', 'url' => '/eliminacion', 'icon' => 'bi bi-trash'],
               // ['name' => 'Configuración', 'url' => '/configuracion', 'icon' => 'bi bi-gear'],
            ];
            $view->with('menuItems', $menuItems);
        });
    }
}
