<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;
use Auth;
class TraspasoServices extends ServiceProvider
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
                if(Auth::user()->rol != 'administrador')
                    $traspasos = DB::select('call notificaciones_traspasos(?)',array(Auth::user()->bussine_id));
                else
                    $traspasos = DB::select('call notificaciones_autorizar_traspaso()');

                //dd($traspasos);
                $view->with('services_traspaso',$traspasos);
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
