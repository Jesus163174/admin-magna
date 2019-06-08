<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer("*",function($view){
            if(Auth::check()){
                $products_bussine = Product::procedureProductsByBussine(Auth::user()->bussine_id);
                $products_all     = Product::procedureIndex();
                $view->with('products_bussine',$products_bussine);
            }

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
