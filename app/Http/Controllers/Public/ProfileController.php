<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Bill;
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
        $userId = Auth::id();
        $bills = Bill::where('customer_id', $userId)->with('billDetails')->get();

        // dd($bills);
        return view(self::PATH_VIEW.__FUNCTION__,[
            'title' => 'Profile',
            'bills' => $bills,
            ...$this->dataHeader
        ]);
    }

}
