<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends CommonController
{
    public function index(){
        return view('pages.public.cart.index', [
            'title' => 'Cart',
            ...$this->dataHeader
        ]);
    }
}
