<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use Auth;
class GlobalProductsServices extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer("*",function($view){
            if(Auth::check()){
                $products_all     = Product::procedureIndex();
                $view->with('products_all',$products_all);
            }

        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
