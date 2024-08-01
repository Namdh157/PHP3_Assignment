<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    const PATH_VIEW = 'pages.public.home.';
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'Trang chủ',
        ]);
    }
}
