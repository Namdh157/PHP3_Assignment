<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function detail($slug){
        echo $slug;
    }

    public function allProduct(){
        
    }
}
