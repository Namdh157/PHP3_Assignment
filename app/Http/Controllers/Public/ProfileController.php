<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    const PATH_VIEW = 'pages.public.profile.';
    public function index()
    {
        $listBrands = Brand::where('is_active',1)->get();
        $listCatalogues = Catalogue::where('is_active',1)->get();
        $user = Auth::user();

        return view(self::PATH_VIEW.__FUNCTION__,[
            'title' => 'Profile',
            'user'=>$user,
            'listBrands' => $listBrands,
            'listCatalogues' => $listCatalogues,
        ]);
    }
}
