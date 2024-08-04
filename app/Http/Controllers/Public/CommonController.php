<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    protected $dataHeader = [];

    public function __construct()
    {
        $this->dataHeader['listCatalogues'] = Catalogue::where('is_active', 1)->get();
        $this->dataHeader['listBrands'] = Brand::where('is_active', 1)->get();
        $this->dataHeader['countCart'] = 0;
        $this->dataHeader['user'] = null;

        $this->middleware( function($request, $next) {
            $this->dataHeader['countCart'] = CartItem::where('user_id', Auth::id())->count();
            $this->dataHeader['user'] = Auth::user();
            return $next($request);
        });
    }
}
