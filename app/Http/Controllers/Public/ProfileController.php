<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends CommonController
{
    const PATH_VIEW = 'pages.public.profile.';
    public function index()
    {
        return view(self::PATH_VIEW.__FUNCTION__,[
            'title' => 'Profile',
            ...$this->dataHeader
        ]);
    }

}
