<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'nombre_cliente',
    	'direccion',
    	'telefono',
    	'modelo_italika',
    	'numero_serie',
    	'garantia',
    	'kilometraje',
    	'orden_servicio',
    	'tipo_servicio',
    	'comentarios',
    	'sin_danios',
    	'sin_odometraje',
    	'precio_mano_obre',
    	'precio_consumible',
    	'precio_refacciones',
    	'total',
    	'fecha_entrega',
    	'telefono_cecit',
    	'venta_id'
    ];

    public static function procedureIndex(){
        return DB::select('call get_servicios_index()');
    }
}
