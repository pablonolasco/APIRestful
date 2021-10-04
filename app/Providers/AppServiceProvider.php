<?php

namespace App\Providers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // se coloca para limitar los caracteres por defecto de 255 a 191, derivado del almacenamiento de caracteres
        Schema::defaultStringLength(191);
        //TODO al crearse el nuevo usuario envia un correo a la cuenta con la que se registro
        User::created(function ($user) {
            //TODO retry realiza los intentos de envio de correo cada segundo y sino envia la excepcion
            retry(5, function () use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));
            }, 100);
        });
        //TODO al cambiar el email ha sido cambiado se enviara correo
        User::updated(function ($user) {
            if ($user->isDirty('email')) {
                retry(5, function () use ($user) {
                    Mail::to($user->email)->send(new UserMailChanged($user));
                }, 100);
            }
        });
        // TODO verifica la existencia del producto
        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->estaDisponible) {
                $product->status = Product::PRODUCTO_NO_DISPONIBLE;
                $product->save();
            }
        });
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
