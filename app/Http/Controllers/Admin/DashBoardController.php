<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    const SIDE_BAR = 'dashboard';
    public function index(){
        return view('pages.admin.dashboard.index', [
            'title' => 'Dashboard',
            'sidebar' => self::SIDE_BAR,
            'breadcrumb' => [
                ['title' => 'Dashboard', 'route' => 'admin.dashboard']
            ]
        ]);
    }
}
