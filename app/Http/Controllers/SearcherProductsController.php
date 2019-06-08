<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
class SearcherProductsController extends Controller
{
    public function __construct($toSearch){
    	$this->toSearch = $toSearch;
    }

    public function searchBySomething(){
    	if(Auth::user()->rol == 'administrador')
    		return Product::procedureSearchBySomething($this->toSearch);
    	return Product::procedureSearchBySomethingSeller($this->toSearch);
    }
}
