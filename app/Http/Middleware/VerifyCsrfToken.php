<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     */
    protected $except = [
        //
    ];


    protected function tokensMatch($request)
{
    $match = parent::tokensMatch($request); // Verifica si el token CSRF es válido
    if (!$match) {
        Log::error('CSRF token mismatch', [
            'session_token' => $request->session()->token(),  // El token guardado en la sesión
            'input_token' => $request->input('_token'),       // El token que vino en el formulario
            'request_path' => $request->path(),                // La URL a la que se hizo la petición
            'headers' => $request->headers->all(),             // Todos los headers enviados
        ]);
    }
    return $match;
}

}
