<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

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
            //para que funcione enviar correo cuando se monte a un servidor se quita
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            /** @var \App\Models\User $user */ // <-- This PHPDoc hint is for Intelephense
            $user = Auth::user();

            $menuItems = [
                ['name' => 'Inicio', 'url' => '/', 'icon' => 'bi bi-house-door', 'roles' => ['admin', 'rrhh', 'employee']],
                ['name' => 'Empleados', 'url' => '/empleados', 'icon' => 'bi bi-person-lines-fill', 'roles' => ['admin', 'rrhh']],
                ['name' => 'Liquidación', 'url' => '/liquidaciones', 'icon' => 'bi bi-cash', 'roles' => ['admin']],
                ['name' => 'Incapacidades', 'url' => '/incapacidades', 'icon' => 'bi bi-file-medical', 'roles' => ['admin', 'rrhh' ]],
                ['name' => 'Pagos', 'url' => '/pagos', 'icon' => 'bi bi-receipt', 'roles' => ['admin', 'rrhh']]
            ];

            $userRole = $user ? $user->role : null;

            $filteredItems = array_filter($menuItems, function ($item) use ($userRole) {
                return empty($item['roles']) || in_array($userRole, $item['roles']);
            });            

            $view->with('menuItems', $filteredItems);
        });
    }
}
