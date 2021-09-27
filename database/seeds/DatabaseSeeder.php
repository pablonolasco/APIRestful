<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Product;
use App\Transaction;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO quitar las llaves foraneas para poder ejecutar el truncate
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        $cantidadUsuarios=200;
        $cantidadCategorias=30;
        $cantidadProductos=1000;
        $cantidadTransacciones=1000;

        factory(User::class,$cantidadUsuarios)->create();
        factory(Category::class,$cantidadCategorias)->create();
        factory(Product::class,$cantidadProductos)->create()->each(function ($product){
            // TODO se obtiene las categorias de manera aleatoria de 1 a 5 categorias
            // TODO pluck sirve para indicar que solo quieres un campo en especifico
            $categories=Category::all()->random(mt_rand(1,5))->pluck('id');

            // TODO se asocian las categorias al producto
            $product->categories()->attach($categories);
        });
        factory(Transaction::class,$cantidadTransacciones)->create();
    }
}
