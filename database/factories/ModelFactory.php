<?php

use App\User;
use App\Product;
use App\Seller;
use App\Category;
use App\Transaction;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;
    $verificado = $faker->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO]);
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'verified' => $verificado,
        'verification_token' => $verificado == User::USUARIO_VERIFICADO ? null : User::generarVerificationToken(),
        'admin' => $faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),
    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->text(100),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->text(100),
        'quantity'=>$faker->numberBetween(1,20),
        'status'=>$faker->randomElement([Product::PRODUCTO_DISPONIBLE,Product::PRODUCTO_NO_DISPONIBLE]),
        'image'=>$faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        //'seller_id'=>User::inRandomOrder()->first()->id,
        'seller_id'=>User::all()->random()->id,
    ];
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {
    // TODO obtiene todos los vendedores
    $vendedor=Seller::has('products')->get()->random();
    // TODO obtiene el comprador que sea diferente al vendedor
    $comprador=User::all()->except($vendedor->id)->random();
    return [
        'quantity' => $faker->numberBetween(1,20),
        'buyer_id' =>$comprador->id,
        'product_id' => $vendedor->products->random()->id,
    ];
});