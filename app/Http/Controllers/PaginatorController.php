<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
class PaginatorController extends Controller
{
    public function __construct($collection_,$setPath_ ,$page_, $total_paginate_){
    	$this->collection = $collection_;
    	$this->page = $page_;
    	$this->total_paginate = $total_paginate_;
    	$this->setPath = $setPath_;
    }
    public function paginatorItems(){
    	$this->collection =   new Paginator($this->collection,$this->total_paginate,$this->page);
    	$this->collection->setPath($this->setPath);
    	return $this->collection;
    }

}
