<?php

namespace App\Http\Middleware;

use Closure;

class SignatureMiddleware
{
    /**
     * Handle an incoming request.
     * TODO el codigo a implementar debe ir en este metodo
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string $header por convencion a las cabeceras personalizadas se le coloca al inicio la letra X
     * @return mixed
     * TODO se ejecuta antes de otro o despues de que se genero la respuesta
     */
    public function handle($request, Closure $next, $header='X-Name')
    {
        // TODO si se desea generar un before middleware se debe agregar la funcionalidad antes de obtener el $next

        // TODO primero se crea la respuesta
        $response= $next($request);
        // TODO cuando se crea despues de a ver obtenido la respuesta se le conoce como after middleware
        // agregar una respuesta a esa cabecera
        $response->headers->set($header,config('app.name'));
        return $response;

    }
}
